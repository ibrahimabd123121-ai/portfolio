<script setup>
import { computed, onMounted, ref } from 'vue'
import Reveal from '@/components/animation/Reveal.vue'
import { getProjects } from '@/services/projectService'

const projects = ref([])
const loading = ref(true)
const error = ref(null)
const searchQuery = ref('')
const selectedTech = ref('all')

const techFilters = computed(() => {
  const names = new Set()

  projects.value.forEach((project) => {
    ;(project.technologies || []).forEach((tech) => {
      if (tech?.name) names.add(tech.name)
    })
  })

  return ['all', ...Array.from(names).sort()]
})

const filteredProjects = computed(() => {
  const query = searchQuery.value.trim().toLowerCase()

  return projects.value.filter((project) => {
    const matchesFilter =
      selectedTech.value === 'all' ||
      (project.technologies || []).some((tech) => tech?.name === selectedTech.value)

    const haystack = [
      project.title,
      project.short_description,
      project.description,
      ...(project.technologies || []).map((tech) => tech?.name),
    ]
      .filter(Boolean)
      .join(' ')
      .toLowerCase()

    const matchesSearch = !query || haystack.includes(query)

    return matchesFilter && matchesSearch
  })
})

onMounted(async () => {
  try {
    const data = await getProjects()
    projects.value = Array.isArray(data) ? data : []
  } catch (err) {
    console.error('error fetching projects:', err)
    error.value = 'Failed to load projects.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <section id="projects" class="projects-section section">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Projects</span>
        <h2>Selected work built to solve real problems.</h2>
      </div>

      <div v-if="loading" class="section-state">
        Loading projects...
      </div>

      <div v-else-if="error" class="section-state section-error">
        {{ error }}
      </div>

      <div v-else class="projects-shell">
        <div class="toolbar">
          <label class="search-box" aria-label="Search projects">
            <span class="search-icon">⌕</span>
            <input v-model="searchQuery" type="search" placeholder="Search projects or tech..." />
          </label>

          <div class="filter-row" aria-label="Project technology filters">
            <button
              v-for="filter in techFilters"
              :key="filter"
              type="button"
              class="filter-chip"
              :class="{ active: selectedTech === filter }"
              @click="selectedTech = filter"
            >
              {{ filter === 'all' ? 'All' : filter }}
            </button>
          </div>
        </div>

        <div class="results-meta">
          <span>{{ filteredProjects.length }} project{{ filteredProjects.length === 1 ? '' : 's' }}</span>
          <button v-if="selectedTech !== 'all' || searchQuery" type="button" class="clear-button" @click="selectedTech = 'all'; searchQuery = ''">
            Reset filters
          </button>
        </div>

        <div v-if="filteredProjects.length" class="projects-grid">
          <Reveal
            v-for="(project, index) in filteredProjects"
            :key="project.id ?? `${project.title}-${index}`"
            class="project-card"
            :delay="index * 80"
          >
            <div class="project-visual" :class="{ featured: project.is_featured }">
              <div v-if="project.image" class="project-image" :style="{ backgroundImage: `url(${project.image})` }" />
              <div v-else class="project-image project-placeholder">
                <span>{{ project.title?.slice(0, 2).toUpperCase() || 'PR' }}</span>
              </div>
              <span v-if="project.is_featured" class="project-badge">Featured</span>
            </div>

            <div class="project-body">
              <h3>{{ project.title }}</h3>

              <p class="project-short">
                {{ project.short_description || project.description || 'No short description available yet.' }}
              </p>

              <div v-if="project.technologies?.length" class="tech-list">
                <span v-for="tech in project.technologies" :key="tech.id ?? tech.name" class="tech-pill">
                  {{ tech.name }}
                </span>
              </div>

              <div v-if="project.live_url || project.github_url" class="project-links">
                <a v-if="project.live_url" :href="project.live_url" target="_blank" rel="noopener noreferrer">Live demo</a>
                <a v-if="project.github_url" :href="project.github_url" target="_blank" rel="noopener noreferrer">GitHub</a>
              </div>
            </div>
          </Reveal>
        </div>

        <div v-else class="section-state empty-state">
          No projects match your current search or filter.
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.projects-section {
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

.projects-shell {
  display: grid;
  gap: 20px;
}

.toolbar {
  display: grid;
  gap: 16px;
  padding: 18px 20px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(15, 23, 42, 0.52);
}

.search-box {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 14px;
  border: 1px solid var(--color-border);
  border-radius: 12px;
  background: rgba(8, 11, 20, 0.4);
}

.search-icon {
  color: var(--color-text-muted);
  font-size: 1.1rem;
}

.search-box input {
  width: 100%;
  border: none;
  background: transparent;
  color: var(--color-text);
  font: inherit;
}

.search-box input:focus {
  outline: none;
}

.filter-row {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.filter-chip {
  padding: 9px 12px;
  border: 1px solid var(--color-border);
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.02);
  color: var(--color-text-muted);
  font-size: 0.8rem;
  transition: all 0.2s ease;
}

.filter-chip.active {
  background: rgba(139, 92, 246, 0.16);
  border-color: rgba(139, 92, 246, 0.5);
  color: var(--color-text);
}

.results-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  color: var(--color-text-muted);
  font-size: 0.9rem;
}

.clear-button {
  padding: 0;
  background: transparent;
  color: var(--color-secondary);
  font: inherit;
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 24px;
}

.project-card {
  display: flex;
  flex-direction: column;
  gap: 0;
  overflow: hidden;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(15, 23, 42, 0.72);
  box-shadow: var(--shadow-card);
  transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}

.project-card:hover {
  transform: translateY(-6px);
  border-color: rgba(139, 92, 246, 0.38);
  box-shadow: 0 18px 35px rgba(15, 23, 42, 0.28);
}

.project-visual {
  position: relative;
  height: 220px;
  overflow: hidden;
  border-bottom: 1px solid var(--color-border);
}

.project-image {
  width: 100%;
  height: 100%;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  transform: scale(1.02);
  transition: transform 0.45s ease;
}

.project-card:hover .project-image {
  transform: scale(1.08);
}

.project-placeholder {
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, rgba(139, 92, 246, 0.32), rgba(34, 211, 238, 0.22));
}

.project-placeholder span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 72px;
  height: 72px;
  border-radius: 18px;
  background: rgba(8, 11, 20, 0.4);
  color: var(--color-text);
  font-size: 1.3rem;
  font-weight: 700;
  letter-spacing: 0.08em;
}

.project-badge {
  position: absolute;
  top: 16px;
  left: 16px;
  display: inline-flex;
  align-items: center;
  border-radius: 999px;
  padding: 6px 10px;
  background: rgba(34, 211, 238, 0.12);
  border: 1px solid rgba(34, 211, 238, 0.3);
  color: var(--color-secondary);
  font-size: 0.68rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.project-body {
  display: flex;
  flex: 1;
  flex-direction: column;
  gap: 16px;
  padding: 24px 22px 22px;
}

.project-card h3 {
  margin: 0;
  font-size: clamp(1.4rem, 2vw, 1.9rem);
}

.project-short {
  margin: 0;
  color: var(--color-text-muted);
  line-height: 1.7;
}

.tech-list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.tech-pill {
  display: inline-flex;
  padding: 7px 10px;
  border: 1px solid var(--color-border);
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.02);
  color: var(--color-text-muted);
  font-size: 0.76rem;
}

.project-links {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: auto;
}

.project-links a {
  color: var(--color-text);
  font-weight: 600;
  transition: color 0.2s ease;
}

.project-links a:hover {
  color: var(--color-secondary);
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

.empty-state {
  min-height: 220px;
}

.section-error {
  color: #fca5a5;
}

@media (max-width: 900px) {
  .projects-grid {
    grid-template-columns: 1fr;
  }
}
</style>
