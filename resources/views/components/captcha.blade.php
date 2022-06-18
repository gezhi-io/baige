<x-label for="captcha" :value="__('Captcha')" />
<div class="grid grid-cols-3">
    <div class="place-self-center">
        <img id="captcha-img" onclick="randcap()" src="{{ captcha_src('math') }}">
    </div>
    <x-input id="captcha" class="block mt-1 w-full col-span-2 place-self-center" name="captcha" type="text" required />
</div>

@pushOnce('js')
    <script>
        var randcap = () => {
            var cimg = document.getElementById('captcha-img');
            var url = "{{ captcha_src('math') }}"
            cimg.setAttribute('src', url + Math.random())
        }
    </script>
@endPushOnce
