<script setup>
import HeroSection from '@/components/home/HeroSection.vue'
import AboutSection from '@/components/home/AboutSection.vue'
import ProjectSection from '@/components/home/ProjectSection.vue'
import SkillsSection from '@/components/SkillsSection.vue'
import TechnologiesSection from '@/components/TechnologiesSection.vue'
import ContactSection from '@/components/home/ContactSection.vue'
import Reveal from '@/components/animation/Reveal.vue'
</script>

<template>
  <main>
    <HeroSection />
    <Reveal>
     <AboutSection />
    </Reveal>
    <Reveal>
     <ProjectSection />
    </Reveal>
    <Reveal>
     <SkillsSection />
    </Reveal>
    <Reveal>
     <TechnologiesSection />
    </Reveal>
    <Reveal>
     <ContactSection />
    </Reveal>
  </main>
</template>

