import { Routes } from '@angular/router';
import { ReviewsComponent } from './reviews.component';

export const routes: Routes = [
  {
    path: '',
    component: ReviewsComponent,
    data: {
      title: 'Reseñas'
    }
  }
];