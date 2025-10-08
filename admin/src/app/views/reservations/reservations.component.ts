import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-reservations',
  template: `
    <div class="row">
      <div class="col-12">
        <h1>Gestión de Reservaciones</h1>
        <p class="text-muted">Administra todas las reservaciones del sistema</p>
        <div class="alert alert-info">
          <strong>Próximamente:</strong> Aquí podrás ver, aprobar y gestionar reservaciones.
        </div>
      </div>
    </div>
  `,
  imports: [CommonModule]
})
export class ReservationsComponent {}