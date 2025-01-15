<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <link href="{{asset('output.css')}}" rel="stylesheet">
</head>
<body>
    <div class="relative flex flex-col w-full min-h-screen max-w-[640px] mx-auto bg-[#F8F8F9]"> 
        <div class="flex flex-col items-center justify-center min-h-screen rounded-[30px] p-5 gap-[14px] bg-white">
            <form action="{{ route('registerasi.submit')}}" method="post" class="w-full max-w-md">
                @csrf
                <div class="flex flex-col mt-6">
                    <label for="name" class="text-sm leading-[21px]">Full Name</label>
                    <div class="flex items-center rounded-lg px-5 gap-[10px] bg-[#F8F8F9] transition-all duration-300 focus-within:ring-1 focus-within:ring-[#F97316]">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="appearance-none outline-none py-[14px] !bg-transparent w-full text-sm leading-[21px] placeholder:font-normal placeholder:text-[#13181D]" placeholder="Write your complete name">
                    </div>
                </div>
    
                <div class="flex flex-col mt-6">
                    <label for="email" class="text-sm leading-[21px]">Email</label>
                    <div class="flex items-center rounded-lg px-5 gap-[10px] bg-[#F8F8F9] transition-all duration-300 focus-within:ring-1 focus-within:ring-[#F97316]">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="appearance-none outline-none py-[14px] !bg-transparent w-full text-sm leading-[21px] placeholder:font-normal placeholder:text-[#13181D]" placeholder="Write your email">
                    </div>
                    @if(session('email_error'))
                        <p class="text-red-500 text-sm mt-1">{{ session('email_error') }}</p>
                    @endif
                </div>
    
                <div class="flex flex-col mt-6 mb-4">
                    <label for="password" class="text-sm leading-[21px]">Password</label>
                    <div class="flex items-center rounded-lg px-5 gap-[10px] bg-[#F8F8F9] transition-all duration-300 focus-within:ring-1 focus-within:ring-[#F97316]">
                        <input type="password" name="password" id="password" class="appearance-none outline-none py-[14px] !bg-transparent w-full text-sm leading-[21px] placeholder:font-normal placeholder:text-[#13181D]" placeholder="Write your password">
                    </div>
                </div>
    
                <button class="bg-[#F97316] text-white py-2 px-4 rounded-lg w-full mt-4">Register</button>
            </form>
    
            <a href="{{ route('login') }}" class="w-full max-w-md">
                <button class="py-2 px-4 rounded-lg w-full mt-4">Login</button>
            </a>
        </div>
    </div>
</body>
</html>