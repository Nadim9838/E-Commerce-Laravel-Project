<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>No Permission</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gradient-to-br from-red-50 to-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-xl w-full animate__animated animate__fadeInDown">
        <div class="text-center">
            <div class="animate__animated animate__tada animate__infinite mb-6">
                <i class="fas fa-ban text-red-500 text-6xl"></i>
            </div>

            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Access Denied</h2>
            <p class="text-gray-600 mb-6 text-sm">You don’t have permission to view this page.</p>

            <div class="bg-gradient-to-r from-blue-50 to-purple-100 p-6 rounded-2xl shadow-inner animate__animated animate__fadeInUp">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Contact Nadim E-Commerce Project Owner</h3>
                <ul class="space-y-3 text-left text-gray-700 text-sm">
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-500"></i>
                        <span><strong>Email:</strong> titanbharatpur@gmail.com</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-green-500"></i>
                        <span><strong>Address:</strong> Bharatpur, Rajasthan</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-red-500"></i>
                        <span><strong>Mobile:</strong> 9782473777</span>
                    </li>
                </ul>
            </div>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

</body>
</html>
