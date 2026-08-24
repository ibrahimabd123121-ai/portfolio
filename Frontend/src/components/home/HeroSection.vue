<template>
    <section class="hero">
        <div class="hero-glow hero-glow-one"></div>
        <div class="hero-glow hero-glow-two"></div>

        <div class="container hero-container">
            <div v-if="profileStore.loading" class="hero-loading">
                Loading...
            </div>

            <div v-else-if="profileStore.error" class="hero-error">
                {{ profileStore.error }}
            </div>

            <div v-else-if="profile" class="hero-content">
                <div class= "hero-badge hero-item">
                    <span class="status-dot"></span>
                    Available for work
                </div>

                <h1 class="hero-item hero-title">
                    Hi, I'm
                    <span>{{ profile.name }}</span>
                    
                </h1>

                <h2 class="hero-item">
                    {{ profile.title }}
                </h2>

                <p class="hero-item">
                    {{ profile.bio }}
                </p>

                <div class="hero-actions hero-item">
                    <RouterLink to="/project" class="btn btn-primary">
                        View My Work
                    </RouterLink>

                    <RouterLink to="/contact" class="btn btn-secondary">
                        Contact Me
                    </RouterLink>
                </div>

                <div class="hero-tech">
                    <span>Laravel</span>
                    <span>Vue.js</span>
                    <span>MySQL</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import { useProfileStore } from '@/stores/profile'

const profileStore = useProfileStore()
const profile = computed(() => profileStore.profile)
</script>

<style scoped>
.hero-item{
    opacity: 0;
    transform: translateY(20px);
    animation: heroFadeUp 0.7s ease forwards;
}

.hero-item:nth-child(1){
    animation-delay: 0.1s;
}

.hero-item:nth-child(2){
 animation-delay: 0.2s;
}

.hero-item:nth-child(3){
 animation-delay: 0.3s;
}

.hero-item:nth-child(4){
 animation-delay: 0.4s;
}

.hero-item:nth-child(5){
 animation-delay: 0.5s;
}

.hero-item:nth-child(6){
 animation-delay: 0.6s;

}
@keyframes heroFadeUp {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to{
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-actions .btn{
    transition: transfrom 0.25 ease;
    box-shadow: 0.25s;
}

.hero-actions .btn:hover{
    transform: translateY(-3px);
}


.hero {
    position: relative;

    min-height: calc(100vh - 80px);

    display: flex;
    align-items: center;

    overflow: hidden;
}

.hero-container {
    position: relative;
    z-index: 2;

    padding-top: 80px;
    padding-bottom: 80px;
}

.hero-content {
    max-width: 850px;
}

/* Badge */

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    padding: 8px 14px;

    margin-bottom: 25px;

    border: 1px solid var(--color-border);

    border-radius: 999px;

    background: rgba(16, 21, 34, 0.7);

    color: var(--color-text-muted);

    font-size: 14px;
}

.status-dot {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #22c55e;

    box-shadow:
        0 0 12px rgba(34, 197, 94, 0.8);
}

/* Title */

.hero-title {
    max-width: 900px;

    font-size: clamp(
        3rem,
        8vw,
        6rem
    );

    font-weight: 700;

    letter-spacing: -0.04em;
}

.hero-title span {
    display: inline-block;

    background: linear-gradient(
        135deg,
        var(--color-primary),
        var(--color-secondary)
    );

    -webkit-background-clip: text;
    background-clip: text;

    color: transparent;
}

/* Subtitle */

.hero-subtitle {
    margin-top: 20px;

    font-size: clamp(
        1.4rem,
        3vw,
        2.2rem
    );

    color: var(--color-text-muted);

    font-weight: 500;
}

/* Description */

.hero-description {
    max-width: 680px;

    margin-top: 25px;

    font-size: 18px;

    line-height: 1.8;
}

/* Actions */

.hero-actions {
    display: flex;

    gap: 14px;

    margin-top: 35px;
}

/* Technologies */

.hero-tech {
    display: flex;

    flex-wrap: wrap;

    gap: 12px;

    margin-top: 45px;
}

.hero-tech span {
    padding: 8px 14px;

    border: 1px solid var(--color-border);

    border-radius: 999px;

    background: rgba(16, 21, 34, 0.6);

    color: var(--color-text-muted);

    font-size: 13px;

    transition:
        color var(--transition),
        border-color var(--transition),
        transform var(--transition);

        
        
}

.hero-tech span:hover {
    color: var(--color-text);

    border-color:
        rgba(139, 92, 246, 0.5);

    transform: translateY(-2px);
}

/* Glow */

.hero-glow {
    position: absolute;

    width: 500px;
    height: 500px;

    border-radius: 50%;

    filter: blur(120px);

    opacity: 0.18;

    pointer-events: none;
}

.hero-glow-one {
    top: -150px;
    left: -100px;

    background: var(--color-primary);
}

.hero-glow-two {
    right: -150px;
    bottom: -200px;

    background: var(--color-secondary);
}

/* Loading */

.hero-loading {
    color: var(--color-text-muted);
}

/* Error */

.hero-error {
    color: #f87171;
}

/* Mobile */

@media (max-width: 768px) {
    .hero {
        min-height: auto;
    }

    .hero-container {
        padding-top: 70px;
        padding-bottom: 70px;
    }

    .hero-title {
        font-size: clamp(
            2.7rem,
            14vw,
            4.5rem
        );
    }

    .hero-actions {
        flex-direction: column;

        align-items: stretch;
    }

    .hero-actions .btn {
        width: 100%;
    }

    .hero-description {
        font-size: 16px;
    }
}
</style>
