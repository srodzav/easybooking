import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-services',
  template: `
    <div class="row">
      <div class="col-12">
        <h1>Gestión de Servicios</h1>
        <p class="text-muted">Administra los servicios disponibles en el sistema</p>
        <div class="alert alert-info">
          <strong>Próximamente:</strong> Aquí podrás crear, editar y eliminar servicios.
        </div>
      </div>
    </div>
  `,
  imports: [CommonModule]
})
export class ServicesComponent {}