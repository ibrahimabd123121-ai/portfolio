<template>
  <footer class="footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <router-link class="nav-brand" :to="{ name: 'home' }" aria-label="Go to home page">
          <span class="brand-mark">I</span>
          <span class="brand-text">
            <span class="brand-name">Ibrahim</span>
            <span class="brand-role">Developer</span>
          </span>
        </router-link>
        <p class="footer-copy">
          Building modern digital experiences that blend performance, clarity, and thoughtful design.
        </p>
      </div>

      <div class="footer-column">
        <h3>Navigate</h3>
        <div class="footer-links">
          <router-link :to="{ name: 'home' }">Home</router-link>
          <router-link :to="{ name: 'about' }">About</router-link>
          <router-link :to="{ name: 'project' }">Projects</router-link>
          <router-link :to="{ name: 'contact' }">Contact</router-link>
        </div>
      </div>

      <div class="footer-column">
        <h3>Connect</h3>
        <div class="footer-links contact-links">
          <a href="mailto:hello@ibrahim.dev">ibrahimabd123121@gmail.com</a>
          <a href="https://github.com" target="_blank" rel="noreferrer">GitHub</a>
          <a href="https://linkedin.com" target="_blank" rel="noreferrer">LinkedIn</a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p>© {{ currentYear }} Ibrahim. All rights reserved.</p>
        <p>Built with Vue & Laravel</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
.footer {
  border-top: 1px solid var(--color-border);
  background: rgba(16, 21, 34, 0.9);
}

.footer-inner {
  display: grid;
  grid-template-columns: 1.3fr 0.8fr 0.9fr;
  gap: 36px;
  padding: 48px 0 28px;
}

.footer-brand {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.nav-brand {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  width: fit-content;
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

.footer-copy {
  max-width: 420px;
  color: var(--color-text-muted);
}

.footer-column {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.footer-column h3 {
  font-size: 0.9rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--color-text);
}

.footer-links {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.footer-links a {
  color: var(--color-text-muted);
  transition: color var(--transition), transform var(--transition);
}

.footer-links a:hover {
  color: var(--color-text);
  transform: translateX(2px);
}

.footer-bottom {
  border-top: 1px solid var(--color-border);
}

.footer-bottom-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 18px 0 30px;
  color: var(--color-text-muted);
  font-size: 0.92rem;
}

@media (max-width: 768px) {
  .footer-inner {
    grid-template-columns: 1fr;
    gap: 24px;
    padding-top: 36px;
  }

  .footer-bottom-inner {
    flex-direction: column;
    text-align: center;
  }
}
</style>
