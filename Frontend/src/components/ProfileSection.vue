<script setup>
import { ref, onMounted } from "vue";
import { getProfile } from "@/services/profileService";

const profile = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    profile.value = await getProfile();
  } catch (err) {
    console.error("error fetching profile:", err);
    error.value = "failed to load profile.";
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <section>
    <h2>Profile</h2>
    <p v-if="loading">Loading profile...</p>
    <p v-else-if="error">{{ error }}</p>

    <div v-else-if="profile">
      <h3>{{ profile.name }}</h3>
      <p v-if="profile.title">{{ profile.title }}</p>
      <p>{{ profile.email }}</p>
      <p v-if="profile.phone">{{ profile.phone }}</p>
      <p v-if="profile.address">{{ profile.address }}</p>
      <p v-if="profile.city || profile.state || profile.country">
        {{ [profile.city, profile.state, profile.country].filter(Boolean).join(", ") }}
      </p>
    </div>
  </section>
</template>
