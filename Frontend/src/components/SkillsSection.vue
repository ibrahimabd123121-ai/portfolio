<script setup>
import { onMounted, ref } from 'vue'
import Reveal from '@/components/animation/Reveal.vue'
import { getSkills } from '@/services/skillService'

const skills = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    skills.value = await getSkills()
  } catch (err) {
    console.error('error fetching skills:', err)
    error.value = 'Failed to load skills.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <section id="skills" class="skills-section section">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Skills</span>
        <h2>Capabilities I use to build thoughtful products.</h2>
      </div>

      <div v-if="loading" class="section-state">
        Loading skills...
      </div>

      <div v-else-if="error" class="section-state section-error">
        {{ error }}
      </div>

      <div v-else-if="skills.length" class="skills-grid">
        <Reveal
          v-for="(skill, index) in skills"
          :key="skill.id"
          class="skill-card"
          :delay="index * 80"
        >
          <div class="skill-icon" aria-hidden="true">{{ skill.icon || '•' }}</div>
          <div class="skill-content">
            <h3>{{ skill.name }}</h3>
            <p v-if="skill.category" class="skill-category">{{ skill.category }}</p>
            <p v-if="skill.level" class="skill-level">Level: {{ skill.level }}</p>
          </div>
        </Reveal>
      </div>

      <div v-else class="section-state">
        No skills available.
      </div>
    </div>
  </section>
</template>

<style scoped>
.skills-section {
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

.skills-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 20px;
}

.skill-card {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 22px 20px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(15, 23, 42, 0.72);
  transition:
    transform 0.3s ease,
    border-color 0.3s ease,
    box-shadow 0.3s ease;
}

.skill-card:hover {
  transform: translateY(-4px);
  border-color: rgba(139, 92, 246, 0.4);
  box-shadow: 0 18px 35px rgba(15, 23, 42, 0.28);
}

.skill-icon {
  display: grid;
  place-items: center;
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(34, 211, 238, 0.2));
  color: var(--color-text);
  font-size: 1.4rem;
  font-weight: 700;
}

.skill-content {
  min-width: 0;
}

.skill-content h3 {
  margin: 0 0 6px;
  font-size: 1.15rem;
}

.skill-category,
.skill-level {
  margin: 0;
  color: var(--color-text-muted);
  font-size: 0.9rem;
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
  .skills-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 560px) {
  .skills-grid {
    grid-template-columns: 1fr;
  }
}
</style>
