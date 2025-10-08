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
    url: '/users',
    iconComponent: { name: 'cil-user' }
  },
  {
    title: true,
    name: 'Servicios'
  },
  {
    name: 'Servicios',
    url: '/services',
    iconComponent: { name: 'cil-notes' }
  },
  {
    name: 'Reservas',
    url: '/reservations',
    iconComponent: { name: 'cil-calendar' }
  },
  {
    name: 'Reseñas',
    url: '/reviews',
    iconComponent: { name: 'cil-star' }
  },
  {
    title: true,
    name: 'Configuración'
  },
  {
    name: 'Reportes',
    url: '/dashboard',
    iconComponent: { name: 'cil-spreadsheet' }
  },
  {
    name: 'Configuración',
    url: '/dashboard',
    iconComponent: { name: 'cil-settings' }
  }
];
