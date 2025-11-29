<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            ลบบัญชี
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            เมื่อบัญชีของคุณถูกลบ ข้อมูลและทรัพยากรทั้งหมดจะถูกลบอย่างถาวร ก่อนลบบัญชี โปรดดาวน์โหลดข้อมูลที่คุณต้องการเก็บไว้
        </p>
    </header>

    <button
        type="button"
        onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
        class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
        <i class="fas fa-trash-alt mr-2"></i>ลบบัญชี
    </button>

    <!-- Delete Confirmation Modal -->
    <div id="deleteAccountModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-2" id="modal-title">
                                    คุณแน่ใจหรือไม่ที่จะลบบัญชี?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 mb-4">
                                        เมื่อบัญชีของคุณถูกลบ ข้อมูลและทรัพยากรทั้งหมดจะถูกลบอย่างถาวร โปรดกรอกรหัสผ่านเพื่อยืนยันการลบบัญชี
                                    </p>

                                    <div class="mt-4">
                                        <label for="delete_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-lock mr-2 text-red-500"></i>รหัสผ่าน
                                        </label>
                                        <input 
                                            id="delete_password" 
                                            name="password" 
                                            type="password" 
                                            placeholder="กรอกรหัสผ่านเพื่อยืนยัน"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                                        />
                                        @error('password', 'userDeletion')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-trash-alt mr-2"></i>ลบบัญชี
                        </button>
                        <button type="button" onclick="document.getElementById('deleteAccountModal').classList.add('hidden')" class="w-full sm:w-auto mt-3 sm:mt-0 px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                            <i class="fas fa-times mr-2"></i>ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('deleteAccountModal').classList.remove('hidden');
    });
</script>
@endif
