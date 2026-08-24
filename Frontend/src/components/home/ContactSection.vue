<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { useProfileStore } from '@/stores/profile'
import Reveal from '../animation/Reveal.vue'
import { sendMessage } from '@/services/contactService'

const profileStore = useProfileStore()
const profile = computed(() => profileStore.profile)

const form = reactive({
  name: '',
  email: '',
  message: '',
})

const isSubmitting = ref(false)
const formStatus = ref({
  type: '',
  message: '',
})

const profileLocation = computed(() => {
  const parts = [
    profile.value?.location,
    profile.value?.city,
    profile.value?.state,
    profile.value?.country,
  ].filter(Boolean)

  return parts.length ? parts.join(', ') : 'Remote / Worldwide'
})

const contactItems = computed(() => [
  {
    label: 'Email',
    value: profile.value?.email || 'hello@ibrahim.dev',
    href: profile.value?.email ? `mailto:${profile.value.email}` : 'mailto:hello@ibrahim.dev',
    icon: '✉',
  },
  {
    label: 'Phone',
    value: profile.value?.phone || '+1 (555) 123-4567',
    href: profile.value?.phone ? `tel:${profile.value.phone}` : 'tel:+15551234567',
    icon: '☎',
  },
  {
    label: 'Location',
    value: profileLocation.value,
    href: null,
    icon: '⌂',
  },
  {
    label: 'Website',
    value: profile.value?.website_url || 'www.ibrahim.dev',
    href: profile.value?.website_url || 'https://www.ibrahim.dev',
    icon: '↗',
  },
])

const socialLinks = computed(() => [
  {
    label: 'GitHub',
    href: profile.value?.github_url || 'https://github.com',
    text: 'GitHub',
  },
  {
    label: 'LinkedIn',
    href: profile.value?.linkedin_url || 'https://www.linkedin.com',
    text: 'LinkedIn',
  },
])

const validateForm = () => {
  if (!form.name.trim() || !form.email.trim() || !form.message.trim()) {
    formStatus.value = {
      type: 'error',
      message: 'Please complete your name, email, and message before sending.',
    }

    return false
  }

  return true
}

const submitForm = async () => {
  if (!validateForm()) {
    return
  }

  isSubmitting.value = true
  formStatus.value = { type: '', message: '' }

  try {
    await sendMessage(form)
    formStatus.value = {
      type: 'success',
      message: 'Your message was sent successfully. I will get back to you soon.',
    }
    form.name = ''
    form.email = ''
    form.message = ''
  } catch (error) {
    const status = error?.response?.status
    const fallbackMessage = status === 404
      ? 'The contact endpoint is not available yet. The UI is ready for the API.'
      : 'Something went wrong while sending your message. Please try again later.'

    formStatus.value = {
      type: 'error',
      message: fallbackMessage,
    }
  } finally {
    isSubmitting.value = false
  }
}

onMounted(async () => {
  if (!profileStore.profile) {
    await profileStore.fetchProfile()
  }
})
</script>

<template>
  <section id="contact" class="contact-section section">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Contact</span>
        <h2>Let’s build something meaningful together.</h2>
      </div>

      <div v-if="profileStore.loading" class="contact-state">Loading contact details...</div>
      <div v-else-if="profileStore.error" class="contact-state contact-error">{{ profileStore.error }}</div>

      <div v-else class="contact-grid">
        <Reveal class="contact-card contact-info" :delay="100">
          <div class="card-header">
            <span class="mini-label">Available for new projects</span>
            <h3>Let’s talk</h3>
          </div>

          <p class="contact-copy">
            I’m available for product work, full-stack builds, and collaborations that need thoughtful design and reliable engineering.
          </p>

          <ul class="contact-list">
            <li v-for="item in contactItems" :key="item.label">
              <span class="contact-icon" aria-hidden="true">{{ item.icon }}</span>

              <div class="contact-meta">
                <span>{{ item.label }}</span>

                <template v-if="item.href">
                  <a :href="item.href" target="_blank" rel="noreferrer">{{ item.value }}</a>
                </template>
                <template v-else>
                  <strong>{{ item.value }}</strong>
                </template>
              </div>
            </li>
          </ul>

          <div class="social-row">
            <a
              v-for="link in socialLinks"
              :key="link.label"
              :href="link.href"
              target="_blank"
              rel="noreferrer"
              class="social-link"
            >
              {{ link.text }}
            </a>
          </div>
        </Reveal>

      
      </div>
    </div>
  </section>
</template>

<style scoped>
.contact-section {
  position: relative;
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

.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1.1fr;
  gap: 28px;
}

.contact-card {
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(15, 23, 42, 0.72);
  box-shadow: var(--shadow-card);
}

.contact-info {
  padding: 30px;
}

.card-header {
  margin-bottom: 18px;
}

.mini-label {
  display: inline-flex;
  margin-bottom: 12px;
  color: var(--color-secondary);
  font-size: 0.76rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.card-header h3 {
  font-size: clamp(1.8rem, 2vw, 2.5rem);
}

.contact-copy {
  margin-bottom: 26px;
  font-size: 1.03rem;
}

.contact-list {
  list-style: none;
  display: grid;
  gap: 18px;
}

.contact-list li {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid rgba(148, 163, 184, 0.14);
}

.contact-list li:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.contact-icon {
  display: grid;
  place-items: center;
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: linear-gradient(135deg, rgba(139, 92, 246, 0.22), rgba(34, 211, 238, 0.18));
  font-size: 1.1rem;
}

.contact-meta {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.contact-meta span {
  font-size: 0.77rem;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--color-text-muted);
}

.contact-meta a,
.contact-meta strong {
  color: var(--color-text);
  font-size: 1rem;
  font-weight: 600;
}

.social-row {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 26px;
}

.social-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 14px;
  border: 1px solid var(--color-border);
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.02);
  color: var(--color-text);
  transition: transform var(--transition), border-color var(--transition), background var(--transition);
}

.social-link:hover {
  transform: translateY(-2px);
  border-color: rgba(139, 92, 246, 0.4);
  background: rgba(139, 92, 246, 0.08);
}

.contact-form-card {
  padding: 30px;
}

.contact-form {
  display: grid;
  gap: 20px;
}

.input-group {
  display: grid;
  gap: 8px;
}

.input-group label {
  color: var(--color-text);
  font-size: 0.92rem;
  font-weight: 600;
}

.input-group input,
.input-group textarea {
  width: 100%;
  padding: 14px 16px;
  border: 1px solid var(--color-border);
  border-radius: 14px;
  background: rgba(8, 11, 20, 0.55);
  color: var(--color-text);
  transition: border-color var(--transition), box-shadow var(--transition);
}

.input-group input::placeholder,
.input-group textarea::placeholder {
  color: rgba(148, 163, 184, 0.85);
}

.input-group input:focus,
.input-group textarea:focus {
  outline: none;
  border-color: rgba(139, 92, 246, 0.7);
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.12);
}

.contact-form .btn {
  justify-self: flex-start;
}

.form-status {
  margin-top: 4px;
  font-size: 0.95rem;
}

.form-status.success {
  color: #86efac;
}

.form-status.error {
  color: #fca5a5;
}

.contact-state {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 200px;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  background: rgba(16, 21, 34, 0.72);
  color: var(--color-text-muted);
}

.contact-error {
  color: #fca5a5;
}

@media (max-width: 900px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }
}
</style>
