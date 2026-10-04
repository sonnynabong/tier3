import type { ImageMetadata } from 'astro';
import findPatients from '../assets/find-patients.svg';
import attractPatients from '../assets/attract-patients.svg';
import fillSchedule from '../assets/fill-schedule.svg';

export interface ProcessStep {
  number: string;
  titleHtml: string;
  body: string;
  illustration: ImageMetadata;
}

export const processIntro = {
  titleHtml: 'A simple<br>prescription<br><span>for profits.</span>',
  body: 'The Growtox System is a proven, done-for-you aesthetic practice marketing solution.',
};

export const processSteps: ProcessStep[] = [
  {
    number: '01',
    titleHtml: 'We find your<br>ideal patients.',
    body: 'Your practice doesn’t need patients. It needs the right kinds of patients. Let our experienced team dig into your area to find exactly the kinds of patients that will help you grow and keep growing a profitable practice.',
    illustration: findPatients,
  },
  {
    number: '02',
    titleHtml: 'We attract your<br>ideal patients.',
    body: 'We use the newest methods of targeting and combine them with highly converting media that lead highly qualified candidates through our new patient scheduling funnels and directly into your chair.',
    illustration: attractPatients,
  },
  {
    number: '03',
    titleHtml: 'We fill<br>your schedule.',
    body: 'We aren’t satisfied with a few new patients or a few great months. We work diligently to ensure that your schedule is full and so you can focus on incredible results for your brand-new patients.',
    illustration: fillSchedule,
  },
];
