import { Routes } from '@angular/router';
import { ReservationsComponent } from './reservations.component';

export const routes: Routes = [
  {
    path: '',
    component: ReservationsComponent,
    data: {
      title: 'Reservaciones'
    }
  }
];