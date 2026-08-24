import api from './api'

export const sendMessage = async (payload = {}) => {
  const data = {
    name: payload.name?.trim() ?? '',
    email: payload.email?.trim() ?? '',
    message: payload.message?.trim() ?? '',
  }

  const response = await api.post('/contact', data)
  return response.data
}

export default sendMessage
