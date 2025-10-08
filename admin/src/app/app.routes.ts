import { Routes } from '@angular/router';
import { DefaultLayoutComponent } from './layout';
import { LoginComponent } from './views/auth/login.component';
import { AuthGuard } from './core/guards/auth.guard';

export const routes: Routes = [
  {
    path: '',
    redirectTo: 'dashboard',
    pathMatch: 'full'
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: '',
    component: DefaultLayoutComponent,
    canActivate: [AuthGuard],
    children: [
      {
        path: 'dashboard',
        loadChildren: () => import('./views/dashboard/dashboard.routes').then(r => r.routes)
      },
      {
        path: 'users',
        loadChildren: () => import('./views/users/users.routes').then(r => r.routes)
      },
      {
        path: 'services',
        loadChildren: () => import('./views/services/services.routes').then(r => r.routes)
      },
      {
        path: 'reservations',
        loadChildren: () => import('./views/reservations/reservations.routes').then(r => r.routes)
      },
      {
        path: 'reviews',
        loadChildren: () => import('./views/reviews/reviews.routes').then(r => r.routes)
      }
    ]
  },
];
