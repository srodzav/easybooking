import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { RowComponent, ColComponent, CardComponent, CardHeaderComponent, CardBodyComponent, WidgetStatAComponent } from '@coreui/angular';
import { IconDirective } from '@coreui/icons-angular';
import { DashboardService, DashboardStats } from '../../core/services/dashboard.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
  imports: [
    CommonModule,
    RouterLink,
    RowComponent,
    ColComponent,
    CardComponent,
    CardHeaderComponent,
    CardBodyComponent,
    WidgetStatAComponent,
    IconDirective
  ]
})
export class DashboardComponent implements OnInit {
  stats: DashboardStats = {
    total_users: 0,
    total_services: 0,
    total_reservations: 0,
    total_reviews: 0,
    pending_reservations: 0,
    confirmed_reservations: 0,
    cancelled_reservations: 0,
    completed_reservations: 0,
    average_rating: 0,
    recent_reservations: [],
    recent_reviews: []
  };

  loading = false;
  error = '';

  constructor(private dashboardService: DashboardService) {}

  ngOnInit(): void {
    this.loadStats();
  }

  private loadStats(): void {
    this.loading = true;
    this.error = '';

    this.dashboardService.getStats().subscribe({
      next: (data) => {
        this.stats = data;
        this.loading = false;
        console.log('Dashboard stats loaded:', data);
      },
      error: (error) => {
        console.error('Error loading dashboard stats:', error);
        this.error = 'Error al cargar las estadísticas del dashboard';
        this.loading = false;
        
        // Fallback a datos mock en caso de error
        this.stats = {
          total_users: 0,
          total_services: 0,
          total_reservations: 0,
          total_reviews: 0,
          pending_reservations: 0,
          confirmed_reservations: 0,
          cancelled_reservations: 0,
          completed_reservations: 0,
          average_rating: 0,
          recent_reservations: [],
          recent_reviews: []
        };
      }
    });
  }

  /**
   * Refresca las estadísticas
   */
  refreshStats(): void {
    this.loadStats();
  }
}