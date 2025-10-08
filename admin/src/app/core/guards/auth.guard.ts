import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { Observable, map, of, catchError } from 'rxjs';
import { AuthService } from '../services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  canActivate(): Observable<boolean> | boolean {
    const token = this.authService.getToken();
    
    // Si no hay token, redirigir al login
    if (!token) {
      console.log('redirect to login');
      this.router.navigate(['/login']);
      return false;
    }

    // Si hay usuario en memoria y es admin, permitir acceso
    const currentUser = this.authService.getCurrentUserValue();
    if (currentUser && currentUser.role === 1) {
      return true;
    }

    // Si hay token pero no usuario en memoria, verificar con el servidor
    return this.authService.getCurrentUser().pipe(
      map(response => {
        if (response.user && response.user.role === 1) {
          console.log('admin');
          return true;
        } else {
          console.log('user is not admin');
          this.router.navigate(['/login']);
          return false;
        }
      }),
      catchError(error => {
        console.log('error:', error);
        this.router.navigate(['/login']);
        return of(false);
      })
    );
  }
}