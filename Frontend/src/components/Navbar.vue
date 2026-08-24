<template>
  <header class="navbar">
    <nav class="nav container" aria-label="Main navigation">
      <router-link class="nav-brand" :to="{ name: 'home' }" aria-label="Go to home page" @click="closeMenu">
        <span class="brand-mark">I</span>
        <span class="brand-text">
          <span class="brand-name">ibrahim</span>
          <span class="brand-role">Developer</span>
        </span>
      </router-link>

      <div class="nav-actions">
        <div class="social-links" aria-label="Social profiles">
          <a href="https://github.com" target="_blank" rel="noreferrer" aria-label="GitHub profile">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 .5A12 12 0 0 0 8.21 23.4c.6.11.82-.26.82-.58v-2.03c-3.34.73-4.04-1.6-4.04-1.6-.55-1.38-1.33-1.75-1.33-1.75-1.09-.75.08-.73.08-.73 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48.99.1-.78.42-1.3.76-1.6-2.67-.31-5.47-1.34-5.47-5.95 0-1.31.47-2.38 1.23-3.22-.12-.3-.53-1.52.12-3.17 0 0 1-.32 3.3 1.23A11.3 11.3 0 0 1 12 6.88c1.01 0 2.03.14 2.98.41 2.29-1.55 3.29-1.23 3.29-1.23.65 1.65.24 2.87.12 3.17.77.84 1.23 1.91 1.23 3.22 0 4.62-2.81 5.63-5.49 5.93.43.38.81 1.12.81 2.25v3.34c0 .32.22.7.83.58A12 12 0 0 0 12 .5Z"/></svg>
          </a>
          <a href="https://www.linkedin.com" target="_blank" rel="noreferrer" aria-label="LinkedIn profile">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.94 8.5A1.56 1.56 0 1 1 6.9 5.38a1.56 1.56 0 0 1 .04 3.12ZM5.5 10h2.9v9H5.5v-9Zm5.2 0h2.78v1.23h.04c.39-.74 1.34-1.52 2.76-1.52 2.96 0 3.51 1.95 3.51 4.48V19h-2.9v-17.74 0-.06c0-1.04-.02-2.38-1.45-2.38-1.45 0-1.67 1.14-1.67 2.3V19h-2.9v-9Z"/></svg>
          </a>
          <a href="mailto:hello@ibrahim.dev" aria-label="Email me">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6.75A2.75 2.75 0 0 1 5.75 4h12.5A2.75 2.75 0 0 1 21 6.75v10.5A2.75 2.75 0 0 1 18.25 20H5.75A2.75 2.75 0 0 1 3 17.25V6.75Zm2.15-.25 6.85 5.31 6.85-5.31H5.15Zm13.1 2.18-6.21 4.82a1 1 0 0 1-1.18 0L5.75 8.68v8.57c0 .42.33.75.75.75h10.99c.42 0 .75-.33.75-.75V8.68Z"/></svg>
          </a>
        </div>

        <button
          class="nav-toggle"
          :class="{ 'is-open': isMenuOpen }"
          type="button"
          @click="toggleMenu"
          :aria-expanded="isMenuOpen"
          aria-controls="mobile-menu"
          aria-label="Toggle navigation menu"
        >
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>

      <div class="nav-links" :class="{ 'is-open': isMenuOpen }" id="mobile-menu" aria-label="Primary navigation">
        <router-link class="nav-link" :to="{ name: 'home' }" @click="closeMenu">Home</router-link>
        <router-link class="nav-link" :to="{ name: 'about' }" @click="closeMenu">About</router-link>
        <router-link class="nav-link" :to="{ name: 'project' }" @click="closeMenu">Projects</router-link>
        <router-link class="nav-link" :to="{ name: 'contact' }" @click="closeMenu">Contact</router-link>
        <a class="nav-cta btn btn-primary" href="mailto:hello@ibrahim.dev" @click="closeMenu">Hire me</a>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const isMenuOpen = ref(false)
const route = useRoute()

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}

watch(
  () => route.name,
  () => {
    closeMenu()
  }
)
</script>

<style scoped>
.navbar {
  position: sticky;
  top: 0;
  z-index: 1000;
  backdrop-filter: blur(16px);
  background: rgba(8, 11, 20, 0.7);
  border-bottom: 1px solid var(--color-border);
}

.nav {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 82px;
  gap: 24px;
}

.nav-brand {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}

.brand-mark {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
  color: white;
  font-family: var(--font-heading);
  font-size: 1.2rem;
  font-weight: 700;
  box-shadow: 0 10px 30px rgba(139, 92, 246, 0.35);
}

.brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1.1;
}

.brand-name {
  font-family: var(--font-heading);
  font-size: 1.05rem;
  font-weight: 700;
}

.brand-role {
  font-size: 0.7rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--color-text-muted);
}

.nav-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.social-links {
  display: flex;
  align-items: center;
  gap: 8px;
}

.social-links a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  border: 1px solid var(--color-border);
  border-radius: 50%;
  color: var(--color-text-muted);
  background: rgba(255, 255, 255, 0.02);
  transition: transform var(--transition), border-color var(--transition), color var(--transition), background var(--transition);
}

.social-links a:hover {
  color: var(--color-text);
  border-color: rgba(139, 92, 246, 0.4);
  background: rgba(139, 92, 246, 0.08);
  transform: translateY(-2px);
}

.social-links svg {
  width: 16px;
  height: 16px;
  fill: currentColor;
}

.nav-links {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  flex-wrap: wrap;
}

.nav-link {
  position: relative;
  padding: 10px 14px;
  font-size: 0.96rem;
  color: var(--color-text-muted);
  border-radius: 999px;
  transition: color var(--transition), background var(--transition), transform var(--transition);
}

.nav-link:hover,
.nav-link.router-link-active {
  color: var(--color-text);
  background: rgba(255, 255, 255, 0.04);
}

.nav-link::after {
  content: '';
  position: absolute;
  left: 14px;
  right: 14px;
  bottom: 8px;
  height: 2px;
  border-radius: 999px;
  background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
  transform: scaleX(0);
  transform-origin: center;
  transition: transform var(--transition);
}

.nav-link:hover::after,
.nav-link.router-link-active::after {
  transform: scaleX(1);
}

.nav-cta {
  padding: 11px 18px;
  font-size: 0.92rem;
}

.nav-toggle {
  display: none;
  position: relative;
  width: 44px;
  height: 44px;
  border: 1px solid var(--color-border);
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.02);
  cursor: pointer;
}

.nav-toggle span {
  position: absolute;
  left: 11px;
  width: 22px;
  height: 2px;
  border-radius: 999px;
  background: var(--color-text);
  transition: transform var(--transition), opacity var(--transition), top var(--transition);
}

.nav-toggle span:nth-child(1) { top: 14px; }
.nav-toggle span:nth-child(2) { top: 21px; }
.nav-toggle span:nth-child(3) { top: 28px; }

.nav-toggle.is-open span:nth-child(1) {
  top: 21px;
  transform: rotate(45deg);
}

.nav-toggle.is-open span:nth-child(2) {
  opacity: 0;
}

.nav-toggle.is-open span:nth-child(3) {
  top: 21px;
  transform: rotate(-45deg);
}

@media (max-width: 768px) {
  .nav {
    min-height: 70px;
    padding: 12px 0;
  }

  .social-links {
    display: none;
  }

  .nav-toggle {
    display: block;
  }

  .nav-links {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    display: none;
    flex-direction: column;
    align-items: stretch;
    gap: 8px;
    padding: 14px;
    border: 1px solid var(--color-border);
    border-radius: 18px;
    background: rgba(10, 14, 24, 0.96);
    box-shadow: var(--shadow-card);
  }

  .nav-links.is-open {
    display: flex;
  }

  .nav-link,
  .nav-cta {
    width: 100%;
    text-align: center;
  }

  .nav-cta {
    display: inline-flex;
    justify-content: center;
  }
}
</style>
