import type { ImageMetadata } from 'astro';
import allure from '../assets/allure.webp';
import refine from '../assets/refine.webp';
import destin from '../assets/destin.webp';
import metro from '../assets/metro.webp';
import facialAesthetics from '../assets/facial-aesthetics.webp';
import lastingImpressions from '../assets/lasting-impressions.webp';
import essential from '../assets/essential.webp';
import smileShop from '../assets/smile-shop.webp';
import trouve from '../assets/trouve.webp';

export interface PracticeLogo {
  src: ImageMetadata;
  width: number;
  height: number;
  alt: string;
}

export const practiceLogos: PracticeLogo[] = [
  { src: allure, width: 176, height: 97, alt: 'Allure Aesthetics' },
  { src: refine, width: 450, height: 288, alt: 'Refine Medical Spa' },
  { src: destin, width: 600, height: 317, alt: 'Destin Botox' },
  { src: metro, width: 900, height: 527, alt: 'Metro Medspa' },
  { src: facialAesthetics, width: 1000, height: 101, alt: 'Facial Aesthetics Team' },
  { src: lastingImpressions, width: 326, height: 150, alt: 'Lasting Impressions Medical Aesthetics' },
  { src: essential, width: 1067, height: 313, alt: 'Essential Aesthetics' },
  { src: smileShop, width: 1000, height: 443, alt: 'Smile Shop Aesthetics' },
  { src: trouve, width: 316, height: 150, alt: 'Trouvé Medspa' },
];
