import { defineStore } from "pinia"
import {ref} from 'vue'
import api from '../services/api'

export const useProfileStore = defineStore('profile', () => {
  const profile = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const fetchProfile = async () => {
    loading.value = true
    error.value = null
    try {
        const respone = await api.get('/profile')

        profile.value = respone.data.data}
    catch (err) {
        console.error ('Error fetching profile:', err)
        error.value = 'Failed to fetch profile. Please try again later.'
    }
    finally {
        loading.value = false
    }
}
return {

    profile,
    loading,
    error,
    fetchProfile,

}
})