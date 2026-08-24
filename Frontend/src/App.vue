<script setup>
import { onMounted } from 'vue'
import { useProfileStore } from '@/stores/profile'

const profileStore = useProfileStore()

onMounted(async () => {
  await profileStore.fetchProfile()
})
</script>

<template>
  <div>
     <router-view />
  </div>
  

</template>

<style scoped></style>
