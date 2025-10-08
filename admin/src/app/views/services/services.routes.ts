import { Routes } from '@angular/router';
import { ServicesComponent } from './services.component';

export const routes: Routes = [
  {
    path: '',
    component: ServicesComponent,
    data: {
      title: 'Servicios'
    }
  }
];