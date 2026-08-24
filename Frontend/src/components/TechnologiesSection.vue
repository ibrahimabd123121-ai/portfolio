<script setup>
import { onMounted, ref } from 'vue'
import { getTechnologies } from '@/services/technologyService'

const technologies = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    technologies.value = await getTechnologies()
  } catch (err) {
    console.error('error fetching technologies:', err)
    error.value = 'Failed to load technologies.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <section id="technologies" class="technologies-section section">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Technologies</span>
        <h2>Tools and stacks I work with every day.</h2>
      </div>

      <div v-if="loading" class="section-state">
        Loading technologies...
      </div>

      <div v-else-if="error" class="section-state section-error">
        {{ error }}
      </div>

      <div v-else-if="technologies.length" class="tech-grid">
        <div v-for="technology in technologies" :key="technology.id" class="tech-card">
          <div class="tech-icon" aria-hidden="true">{{ technology.icon || '▣' }}</div>
          <span>{{ technology.name }}</span>
        </div>
      </div>

      <div v-else class="section-state">
        No technologies available.
      </div>
    </div>
  </section>
</template>

<style scoped>
.technologies-section {
  padding-top: 76px;
  padding-bottom: 76px;
}

.section-heading {
  max-width: 700px;
  margin-bottom: 40px;
}

.eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 16px;
  color: var(--color-secondary);
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
}

.eyebrow::before {
  content: '';
  width: 34px;
  height: 1px;
  background: rgba(34, 211, 238, 0.8);
}

.tech-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 18px;
}

.tech-card {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 18px 20px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(15, 23, 42, 0.72);
}

.tech-icon {
  display: grid;
  place-items: center;
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: rgba(34, 211, 238, 0.12);
  color: var(--color-secondary);
  font-weight: 700;
}

.tech-card span {
  color: var(--color-text);
  font-weight: 600;
}

.section-state {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 180px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(16, 21, 34, 0.72);
  color: var(--color-text-muted);
}

.section-error {
  color: #fca5a5;
}

@media (max-width: 900px) {
  .tech-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 560px) {
  .tech-grid {
    grid-template-columns: 1fr;
  }
}
</style>
