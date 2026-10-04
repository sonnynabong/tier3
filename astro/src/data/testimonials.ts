import type { ImageMetadata } from 'astro';
import connieBrooks from '../assets/connie-brooks.webp';
import graceChung from '../assets/grace-chung.webp';

export interface Testimonial {
  variant: 'lead' | 'secondary';
  quote: string;
  name: string;
  alt: string;
  detailHtml: string;
  portrait: ImageMetadata;
  width: number;
  height: number;
}

export const testimonials: Testimonial[] = [
  {
    variant: 'lead',
    quote:
      'Over 80 bookings. My entire month was filled up in about two weeks! Tier3 Media is top notch!!',
    name: 'Dr. Connie L. Brooks - Fernandez MD',
    alt: 'Dr. Connie L. Brooks-Fernandez',
    detailHtml: 'Allure Aesthetics',
    portrait: connieBrooks,
    width: 88,
    height: 88,
  },
  {
    variant: 'secondary',
    quote:
      'I’m a startup practice that now has more than 44 new patients per week. I’d highly recommend Tier3 Media.',
    name: 'Dr. Grace Chung',
    alt: 'Dr. Grace Chung',
    detailHtml: 'Owner of Smile Shop Dental &amp; Aesthetics<br>Henderson, Nevada',
    portrait: graceChung,
    width: 72,
    height: 72,
  },
];
