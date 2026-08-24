<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'

const props = defineProps({
  delay: {
   type: Number,
   default: 0,
  },
  duration: {
   type: Number,
   default: 700,
  },
  distance: {
   type: Number,
   default: 36,
  },
  threshold: {
   type: Number,
   default: 0.15,
  },
  once: {
   type: Boolean,
   default: true,
  },
})

const element = ref(null)
const isVisible = ref(false)
let observer = null

const stopObserver = () => {
  if (observer) {
   observer.disconnect()
   observer = null
  }
}

onMounted(() => {
  if (!element.value) return

  observer = new IntersectionObserver(
   ([entry]) => {
     if (!entry.isIntersecting) return

     isVisible.value = true

     if (props.once && observer) {
       observer.unobserve(entry.target)
     }
   },
   { threshold: props.threshold },
  )

  observer.observe(element.value)
})

onBeforeUnmount(() => {
  stopObserver()
})
</script>

<template>
  <div
   ref="element"
   class="animation-reveal"
   :class="{ 'is-visible': isVisible }"
   :style="{
     '--reveal-delay': `${delay}ms`,
     '--reveal-duration': `${duration}ms`,
     '--reveal-distance': `${distance}px`,
   }"
  >
   <slot />
  </div>
</template>

<style scoped>
.animation-reveal {
  opacity: 0;
  transform: translateY(var(--reveal-distance, 36px));
  transition:
   opacity var(--reveal-duration, 700ms) cubic-bezier(0.22, 1, 0.36, 1),
   transform var(--reveal-duration, 700ms) cubic-bezier(0.22, 1, 0.36, 1);
  transition-delay: var(--reveal-delay, 0ms);
  will-change: opacity, transform;
}

.animation-reveal.is-visible {
  opacity: 1;
  transform: translateY(0);
}

@media (prefers-reduced-motion: reduce) {
  .animation-reveal {
   opacity: 1;
   transform: none;
   transition: none;
  }
}
</style>
