<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome — USeP OSAS Sports Unit</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/SportOffice.png" sizes="any" />
    <style>
        :root {
            --maroon:      #7A1428;
            --maroon-dark: #500D1A;
            --gold:        #F0B429;
            --white:       #FFFFFF;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { margin: 0; background: var(--maroon-dark); overflow: hidden; height: 100vh; display: flex; align-items: center; justify-content: center; }

        .intro-loader {
            position: fixed; inset: 0; background: var(--maroon-dark);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            z-index: 2000;
        }

        .intro-logo-wrap { position: relative; width: 140px; height: 140px; margin-bottom: 30px; scale: 0.8; opacity: 0; transition: all 1s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .intro-loader.active .intro-logo-wrap { scale: 1; opacity: 1; }
        
        .intro-logo { width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 0 20px rgba(240,180,41,0.4)); }
        
        .intro-orbit {
            position: absolute; inset: -15px; border: 2px solid var(--gold); border-radius: 50%;
            border-right-color: transparent; border-bottom-color: transparent;
            animation: intro-spin 2s linear infinite;
        }
        
        .intro-text { text-align: center; overflow: hidden; height: 50px; }
        .intro-text h1 {
            font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 800;
            color: var(--gold); text-transform: uppercase; letter-spacing: 8px;
            transform: translateY(100%); transition: transform .6s cubic-bezier(0.34, 1.56, 0.64, 1) .3s;
        }
        .intro-loader.active .intro-text h1 { transform: translateY(0); }
        
        .intro-line { width: 0; height: 2px; background: var(--gold); margin-top: 15px; transition: width .8s ease .6s; }
        .intro-loader.active .intro-line { width: 200px; }

        @keyframes intro-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .fade-out { opacity: 0; transition: opacity 0.6s ease; }
    </style>
</head>
<body>
    <div class="intro-loader active" id="introLoader">
        <div class="intro-logo-wrap">
            <div class="intro-orbit"></div>
            <img src="/image/SportOffice.png" alt="Logo" class="intro-logo">
        </div>
        <div class="intro-text">
            <h1>USeP OSAS Sports</h1>
        </div>
        <div class="intro-line"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const introLoader = document.getElementById('introLoader');
            
            // If they've already seen it this session (tab session), skip to login instantly
            // This ensures it plays again if they close the tab/browser and return.
            if (sessionStorage.getItem('introPlayedThisSession')) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            // Otherwise, show the loader (it's active by default in HTML)
            // and play the animation
            setTimeout(() => {
                introLoader.classList.add('fade-out');
                sessionStorage.setItem('introPlayedThisSession', 'true');
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1);
            }, 1);
        });
    </script>
</body>
</html>
