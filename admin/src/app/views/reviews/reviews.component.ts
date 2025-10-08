import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-reviews',
  template: `
    <div class="row">
      <div class="col-12">
        <h1>Gestión de Reseñas</h1>
        <p class="text-muted">Administra y modera las reseñas de los usuarios</p>
        <div class="alert alert-info">
          <strong>Próximamente:</strong> Aquí podrás ver, moderar y responder reseñas.
        </div>
      </div>
    </div>
  `,
  imports: [CommonModule]
})
export class ReviewsComponent {}