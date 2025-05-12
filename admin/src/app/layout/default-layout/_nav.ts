import { INavData } from '@coreui/angular';

export const navItems: INavData[] = [
  {
    name: 'Dashboard',
    url: '/dashboard',
    iconComponent: { name: 'cil-speedometer' },
  },
  {
    title: true,
    name: 'Usuarios'
  },
  {
    name: 'Usuarios',
    url: '/theme/colors',
    iconComponent: { name: 'cil-user' }
  },
  {
    title: true,
    name: 'Servicios'
  },
  {
    name: 'Servicios',
    url: '/theme/colors',
    iconComponent: { name: 'cil-notes' }
  },
  {
    name: 'Horarios',
    url: '/theme/colors',
    iconComponent: { name: 'cil-clock' }
  },
  {
    name: 'Reservas',
    url: '/theme/colors',
    iconComponent: { name: 'cil-calendar' }
  },
  {
    name: 'Reseñas',
    url: '/theme/colors',
    iconComponent: { name: 'cil-star' }
  },
  {
    title: true,
    name: 'Configuración'
  },
  {
    name: 'Reportes',
    url: '/theme/colors',
    iconComponent: { name: 'cil-spreadsheet' }
  },
  {
    name: 'Configuración',
    url: '/theme/colors',
    iconComponent: { name: 'cil-settings' }
  }
];
