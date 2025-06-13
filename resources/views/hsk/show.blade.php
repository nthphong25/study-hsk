<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>HSK Từ vựng</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        .flashcard {
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flashcard.flipped {
            transform: rotateY(180deg);
        }

        .flashcard .front,
        .flashcard .back {
            backface-visibility: hidden;
        }

        .flashcard .back {
            transform: rotateY(180deg);
        }
    </style>
</head>

<body class="min-h-screen text-white" style="background-image: url('{{ asset('img/bg.jpg') }}'); background-size: cover;">
    <div
        class="w-fit mx-auto justify-center flex flex-col items-center p-6 mt-10 bg-white/10 backdrop-blur-lg rounded-xl border border-gray-300">
        {{-- <h1 class="text-3xl font-bold mb-6">🈶 Học từ vựng HSK cùng Caohehaifeng</h1> --}}

        <div class="flex items-center gap-4 mb-4">
            <select id="level-select" class="border border-gray-300 rounded px-3 py-2 text-lg text-black bg-transparent">
                <option value=""> Chọn cấp độ HSK </option>
                @for ($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}">HSK {{ $i }}</option>
                @endfor
            </select>

            <div class="relative inline-flex group">
                <div
                    class="absolute transitiona-all duration-1000 opacity-70 -inset-px bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] rounded-xl blur-lg filter group-hover:opacity-100 group-hover:-inset-1 group-hover:duration-200">
                </div>
                <a onclick="getRandomWord()" title="" role="button"
                    class="relative inline-flex items-center justify-center px-5 py-2 text-base font-bold text-white transition-all duration-200 bg-gray-900 border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 hover:bg-gray-600 rounded">
                    🎲 Learn more
                </a>
            </div>
        </div>

        <div id="random-word" class="flex justify-center"></div>

    </div>

    <script>
        function getRandomWord() {
            const level = document.getElementById("level-select").value;
            if (!level) {
                alert("⚠️ Vui lòng chọn cấp độ HSK.");
                return;
            }

            fetch(`/api/hsk/${level}/random`)
                .then(res => res.json())
                .then(word => {
                    const html = `
                        <div class="flashcard-container w-full sm:w-[400px] mx-auto">
                            <div class="flashcard relative w-full h-[220px] rounded-xl cursor-pointer">
                                <div class="front absolute inset-0 bg-sky-100 p-6 flex items-center justify-center text-center text-4xl font-bold text-yellow-800 rounded-xl shadow-xl">
                                    ${word.meaning}
                                </div>
                                <div class="back absolute inset-0 bg-white p-6 text-black rounded-xl shadow-xl transform rotate-y-180">
                                    <div class="font-bold text-3xl mb-1">📖 ${word.word} - ${word.pronunciation}</div>
                                    <div class="italic text-gray-700 mb-1">💬 ${word.example}</div>
                                    <div class="text-sm text-gray-600 mb-1">🔊 ${word.example_pronunciation}</div>
                                    <div class="text-sm text-gray-800">VN: ${word.example_translation}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('random-word').innerHTML = html;

                    // Gắn sự kiện click để lật flashcard
                    const card = document.querySelector('.flashcard');
                    card.addEventListener('click', () => {
                        card.classList.toggle('flipped');
                    });
                })
                .catch(err => {
                    alert("❌ Không lấy được từ.");
                    console.error(err);
                });
        }
    </script>
</body>

</html>
