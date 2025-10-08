import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';

export interface DashboardStats {
  total_users: number;
  total_services: number;
  total_reservations: number;
  total_reviews: number;
  pending_reservations: number;
  confirmed_reservations: number;
  cancelled_reservations: number;
  completed_reservations: number;
  average_rating: number;
  recent_reservations: any[];
  recent_reviews: any[];
}

@Injectable({
  providedIn: 'root'
})
export class DashboardService {
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  /**
   * Obtiene las estadísticas generales del dashboard
   */
  getStats(): Observable<DashboardStats> {
    return this.http.get<DashboardStats>(`${this.apiUrl}/dashboard/stats`);
  }

  /**
   * Obtiene estadísticas por rango de fechas
   */
  getStatsByDateRange(startDate: string, endDate: string): Observable<DashboardStats> {
    return this.http.get<DashboardStats>(`${this.apiUrl}/dashboard/stats`, {
      params: {
        start_date: startDate,
        end_date: endDate
      }
    });
  }

  /**
   * Obtiene las reservaciones recientes
   */
  getRecentReservations(limit: number = 10): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/dashboard/recent-reservations`, {
      params: { limit: limit.toString() }
    });
  }

  /**
   * Obtiene las reseñas recientes
   */
  getRecentReviews(limit: number = 10): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/dashboard/recent-reviews`, {
      params: { limit: limit.toString() }
    });
  }
}