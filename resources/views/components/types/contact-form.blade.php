@php
    $title = $content['title'] ?? 'Contáctanos';
    $fields = $content['fields'] ?? ['name', 'email', 'message'];
    $buttonText = $content['button_text'] ?? 'Enviar Mensaje';
@endphp

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
            
            <form action="#" method="POST" class="space-y-6" x-data="contactForm()">
                @csrf
                
                @if(in_array('name', $fields))
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                @endif
                
                @if(in_array('email', $fields))
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                @endif
                
                @if(in_array('phone', $fields))
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                @endif
                
                @if(in_array('message', $fields))
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Mensaje
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"></textarea>
                    </div>
                @endif
                
                <div>
                    <button type="submit" 
                            class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-200">
                        {{ $buttonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function contactForm() {
        return {
            // Aquí puedes agregar lógica de validación o envío AJAX
        }
    }
</script>
