<script setup>
import { computed, onMounted } from 'vue'
import { useProfileStore } from '@/stores/profile'

const profileStore = useProfileStore()
const profile = computed(() => profileStore.profile)

const initials = computed(() => {
  const name = profile.value?.name || ''
  const lastName = profile.value?.last_name || ''
  const parts = [name, lastName].filter(Boolean)

  if (!parts.length) return 'ME'

  return parts
    .slice(0, 2)
    .map((part) => part.charAt(0).toUpperCase())
    .join('')
})

const highlights = computed(() => [
  { label: 'Role', value: profile.value?.title || 'Full-stack developer' },
  { label: 'Location', value: [profile.value?.city, profile.value?.state, profile.value?.country].filter(Boolean).join(', ') || 'Remote' },
  { label: 'Focus', value: 'Product design & reliable delivery' },
])

const profileDetails = computed(() => [
  {
    label: 'Email',
    value: profile.value?.email || null,
    
  },
  {
    label: 'Phone',
    value: profile.value?.phone || null,
   
  },
  {
    label: 'Location',
    value: [profile.value?.city, profile.value?.state, profile.value?.address].filter(Boolean).join(', ') || null,
    
  },
])

onMounted(async () => {
  if (!profileStore.profile) {
    await profileStore.fetchProfile()
  }
})
</script>

<template>
  <section id="about" class="about-section section">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">About me</span>
        <h2>Designing digital experiences with clarity and purpose.</h2>
      </div>

      <div v-if="profileStore.loading" class="about-state">
        Loading profile...
      </div>

      <div v-else-if="profileStore.error" class="about-state about-error">
        {{ profileStore.error }}
      </div>

      <div v-else-if="profile" class="about-grid">
        <article class="card about-copy">
          <p class="about-intro">
            Hi, I’m {{ profile.name }} — a {{ profile.title || 'full-stack developer' }} focused on crafting clean, reliable, and user-friendly interfaces.
          </p>

          <p>
            {{ profile.bio || 'I enjoy turning ideas into thoughtful digital products that are easy to use and built to last.' }}
          </p>

          <p>
            My process blends strategic thinking, technical depth, and a strong eye for detail so projects feel polished from the first interaction to the final launch.
          </p>

          <div class="highlights">
            <div v-for="item in highlights" :key="item.label" class="highlight-item">
              <span class="highlight-label">{{ item.label }}</span>
              <strong>{{ item.value }}</strong>
            </div>
          </div>
        </article>

        <aside class="card about-profile">
          <div class="profile-card-header">
            <div class="avatar-wrap">
              <div class="avatar">{{ initials }}</div>
            </div>

            <div>
              <h3>{{ profile.name || 'Profile' }}</h3>
              <p>{{ profile.title || 'Developer' }}</p>
            </div>
          </div>

          <ul class="profile-details">
            <li v-for="detail in profileDetails" :key="detail.label">
              <span>{{ detail.label }}</span>

              <template v-if="detail.href && detail.value">
                <a :href="detail.href">{{ detail.value }}</a>
              </template>

              <template v-else>
                {{ detail.value || 'Not available' }}
              </template>
            </li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
</template>

<style scoped>
.about-section {
  position: relative;
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

.about-grid {
  display: grid;
  grid-template-columns: 1.4fr 0.8fr;
  gap: 28px;
}

.about-copy,
.about-profile {
  min-height: 100%;
}

.about-copy {
  padding: 32px;
}

.about-intro {
  margin-bottom: 18px;
  color: var(--color-text);
  font-size: clamp(1.2rem, 2vw, 1.55rem);
  line-height: 1.5;
}

.about-copy p + p {
  margin-top: 18px;
}

.highlights {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 16px;
  margin-top: 32px;
}

.highlight-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
  padding: 16px 18px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  background: rgba(255, 255, 255, 0.02);
}

.highlight-label {
  color: var(--color-text-muted);
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.highlight-item strong {
  color: var(--color-text);
  font-size: 1.02rem;
}

.about-profile {
  padding: 28px;
}

.profile-card-header {
  display: flex;
  align-items: center;
  gap: 18px;
  margin-bottom: 24px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--color-border);
}

.avatar-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 76px;
  height: 76px;
  border-radius: 50%;
  background: linear-gradient(
    135deg,
    rgba(139, 92, 246, 0.3),
    rgba(34, 211, 238, 0.2)
  );
  border: 1px solid rgba(139, 92, 246, 0.4);
}

.avatar {
  display: grid;
  place-items: center;
  width: 58px;
  height: 58px;
  border-radius: 50%;
  background: rgba(8, 11, 20, 0.9);
  color: var(--color-text);
  font-weight: 700;
  letter-spacing: 0.08em;
}

.profile-card-header h3 {
  font-size: 1.5rem;
}

.profile-card-header p {
  margin-top: 6px;
}

.profile-details {
  list-style: none;
  display: grid;
  gap: 16px;
}

.profile-details li {
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding-bottom: 12px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.profile-details span {
  color: var(--color-text-muted);
  font-size: 0.82rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.profile-details a,
.profile-details :not(a) {
  color: var(--color-text);
}

.profile-details a:hover {
  color: var(--color-secondary);
}

.about-state {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 180px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(16, 21, 34, 0.72);
  color: var(--color-text-muted);
}

.about-error {
  color: #fca5a5;
}

@media (max-width: 900px) {
  .about-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 560px) {
  .about-copy,
  .about-profile {
    padding: 22px 18px;
  }

  .highlights {
    grid-template-columns: 1fr;
  }

  .profile-card-header {
    align-items: flex-start;
  }
}
</style>

