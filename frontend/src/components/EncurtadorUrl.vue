<template>

  <div class="flex flex-col justify-center items-center min-h-screen">

    <div class="p-1 flex flex-row gap-4">
      <img src="/vite.svg" class="h-10" alt="Vite logo" />
      <img src="../assets/vue.svg" class="h-10" alt="Vue logo" />
    </div>
    
    <div class="p-8 flex flex-col items-center">
      <h1 class="text-2xl font-bold mb-4">Encurtador de URL com VueJS</h1>
      <input v-model="url" placeholder="Digite a URL" class="border p-2 w-full mb-4 rounded-sm" />
      <span v-if="error" class="text-lg dark:text-red-300 mb-4">{{ error }}</span>
      
      <div>
        <button @click="encurtar" type="button" 
          class="bg-blue-500 text-white px-4 py-2 rounded hover:cursor-pointer hover:bg-blue-700">
          Encurtar
        </button>
        <button v-if="url || resultado" @click="limpar" type="button" 
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:cursor-pointer hover:bg-yellow-700 ml-3"> 
          Limpar
        </button>
      </div>

      <!-- Div que exibe uma animação de carregamento ao fazer a requisição para o backend -->
      <div v-if="loading" class="mt-4 w-full border-1 border-white-300 p-3 rounded-sm">
          <div class="animate-pulse">
            <div class="space-y-3">
              <div class="h-1 rounded bg-gray-100"></div>
              <div class="h-1 rounded bg-gray-100"></div>
            </div>
          </div>
      </div>

      <!-- A div de carregamento é ocultada logo após o backend enviar a resposta ao frontend -->
      <div v-if="resultado && !loading" class="mt-4 w-full border-2 border-white-300 p-3 rounded-lg">
        <p><strong>Original:</strong> {{ resultado.original }}</p>
        <p><strong>Encurtada:</strong> <a :href="resultado.short" target="_blank">{{ resultado.short }}</a></p>
      </div>

    </div>

  </div>

</template>

<script setup>
  import { ref } from 'vue'
  import axios from 'axios'

  const regex = /^(https?:\/\/)/

  const url = ref('')
  const resultado = ref(null)
  const error = ref(null)
  const loading = ref(false)

  function limpar() {
    url.value = ''
    resultado.value = ''
    error.value = ''
  }

  const encurtar = async () => {
    if (!url.value) return

    if  (!regex.test(url.value)) {
      error.value = 'A URL precisa conter "http:// ou https://"'
      return
    } else {
      error.value = ''
    }

    loading.value = true
    resultado.value = null

    try {
      const res = await axios.post('http://127.0.0.1:8000/api.php', { url: url.value })
      resultado.value = res.data
    } catch (error) {
      alert('Erro ao encurtar a URL')
    } finally {
      loading.value = false
    }
  }
</script>