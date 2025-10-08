import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, tap, catchError } from 'rxjs';

export interface User {
  id: number;
  name: string;
  email: string;
  phone?: string;
  role: number;
  is_admin: boolean;
}

export interface LoginResponse {
  message: string;
  access_token: string;
  token_type: string;
  user: User;
}

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private readonly API_URL = 'http://127.0.0.1:8000/api';
  private currentUserSubject = new BehaviorSubject<User | null>(null);
  private tokenKey = 'easybooking_token';

  public currentUser$ = this.currentUserSubject.asObservable();

  constructor(private http: HttpClient) {
    // Verificar si hay un token guardado al inicializar
    this.checkStoredAuth();
  }

  /**
   * Login de administrador
   */
  login(email: string, password: string): Observable<LoginResponse> {
    return this.http.post<LoginResponse>(`${this.API_URL}/login`, {
      email,
      password
    }).pipe(
      tap(response => {
        // Verificar que el usuario sea admin
        if (response.user.role !== 1) {
          throw new Error('Acceso denegado. Solo administradores pueden acceder.');
        }
        
        // Guardar token y usuario
        localStorage.setItem(this.tokenKey, response.access_token);
        this.currentUserSubject.next(response.user);
      })
    );
  }

  /**
   * Logout
   */
  logout(): Observable<any> {
    const token = this.getToken();
    
    if (!token) {
      // Si no hay token, solo limpiar localmente
      this.clearAuth();
      return new Observable(subscriber => {
        subscriber.next({ message: 'Logout local exitoso' });
        subscriber.complete();
      });
    }

    return this.http.post(`${this.API_URL}/logout`, {}).pipe(
      tap(() => {
        console.log('logout');
        this.clearAuth();
      }),
      catchError((error) => {
        console.log('error:', error);
        // Incluso si falla el logout en el servidor, limpiamos localmente
        this.clearAuth();
        // Retornamos un observable exitoso para no mostrar error al usuario
        return new Observable(subscriber => {
          subscriber.next({ message: 'Logout exitoso' });
          subscriber.complete();
        });
      })
    );
  }

  /**
   * Obtener usuario actual desde el servidor
   */
  getCurrentUser(): Observable<{user: User}> {
    return this.http.get<{user: User}>(`${this.API_URL}/me`).pipe(
      tap(response => {
        // Verificar que siga siendo admin
        if (response.user.role !== 1) {
          this.clearAuth();
          throw new Error('Acceso denegado. Solo administradores pueden acceder.');
        }
        this.currentUserSubject.next(response.user);
      })
    );
  }

  /**
   * Verificar si hay autenticación guardada
   */
  private checkStoredAuth(): void {
    const token = this.getToken();
    if (token) {
      // Verificar token con el servidor
      this.getCurrentUser().subscribe({
        next: () => {
          // Token válido, usuario ya establecido en tap()
          console.log('valid token, user authenticated');
        },
        error: (error) => {
          console.log('error validating stored token:', error);
          // Token inválido, limpiar
          this.clearAuth();
        }
      });
    }
  }

  /**
   * Obtener token guardado
   */
  getToken(): string | null {
    return localStorage.getItem(this.tokenKey);
  }

  /**
   * Verificar si está autenticado
   */
  isAuthenticated(): boolean {
    const token = this.getToken();
    const user = this.currentUserSubject.value;
    return !!token && !!user && user.role === 1;
  }

  /**
   * Verificar si es admin
   */
  isAdmin(): boolean {
    const user = this.currentUserSubject.value;
    return user?.role === 1 || false;
  }

  /**
   * Obtener usuario actual
   */
  getCurrentUserValue(): User | null {
    return this.currentUserSubject.value;
  }

  /**
   * Limpiar autenticación (método público para el interceptor)
   */
  clearAuthData(): void {
    localStorage.removeItem(this.tokenKey);
    this.currentUserSubject.next(null);
  }

  /**
   * Limpiar autenticación (método privado)
   */
  private clearAuth(): void {
    this.clearAuthData();
  }
}
