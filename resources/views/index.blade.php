    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class=" bg-neutral">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ABUBAKR-ChatGPT Clone</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="antialiased min-h-screen md:px-2  ">

        <nav class="navbar relative z-50 -bottom-2 shadow-lg bg-base-100 rounded-3xl  px-4">
            <div class="flex-1">
                <span class=" normal-case text-xl text-primary">ChatGPT Clone</span>

            </div>
            <div class="md:hidden flex ">
                <div class="flex justify-start gap-2  items-center stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-5 h-5 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <div class="stat-value text-secondary text-sm font-normal mb-0.5">2 <span class="">messages
                            left</span></div>
                </div>


            </div>
        </nav>
        <main class="flex items-stretch h-full md:mx-2 mb-5">
            <aside class="md:w-1/4 w-0 bg-base-300 rounded-l-3xl shadow-lg pt-10">
                <div class="shadow-lg px-5 ">
                    <div class="stat-title font-bold">Messages Left</div>
                    <div class="flex justify-start gap-3 my-2 items-center stat-figure text-secondary">
                        <div class="stat-value text-secondary">2</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>


                    <div class="stat-desc whitespace-normal">You only have 5 messages per a day </div>
                </div>
            </aside>
            <section class="md:w-3/4 w-full rounded-r-xl relative bg-neutral-focus ">
                <div id="chat-container" class="pt-10 h-[75vh] overflow-y-auto md:p-5 p-2">
            
               
                </div>
                <div
                    class="w-full grid grid-cols-12 gap-2 rounded-r-xl rounded-tl-xl bg-base-100  p-2 rounded-bl-none sticky bottom-0-0 left-0 right-0">
                    <div class="col-span-9 sm:col-span-10  form-control relative">
                        <label class="label absolute -top-1 right-0">

                            <span id="input-counter" class="label-text-alt text-primary"></span>
                        </label>
                        <textarea maxlength="300" id="autoresizing" placeholder="Bio"
                            class="w-full block textarea textarea-primary textarea-ghost e overflow-hidden resize-none !outline-none  rounded-bl-none py-0 pt-4  textarea-xs   "></textarea>

                    </div>
                    <button id="send-btn" class="btn  h-[55px]    col-span-3 sm:col-span-2 btn-primary  btn-outline">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            class="h-7 w-7 "
                            style="stroke-width: var(--grid-item-icon-stroke-width); transform: scale(var(--grid-item-icon-scale));">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5">
                            </path>
                        </svg>
                    </button>
                </div>
            </section>
        </main>
    </body>
    <script>
        textarea = document.querySelector("#autoresizing");
        inputCounter = document.querySelector("#input-counter");
        chatContainer = document.querySelector("#chat-container");
        sendBtn = document.querySelector("#send-btn");


        textarea.addEventListener("input", hundleInput, false);
        sendBtn.addEventListener('click', send);
        textarea.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                send();
            }
        });
        countInput();
        scroolToBottom();

        async function send(e) {

            sendBtn.disabled = true;
            textarea.disabled = true;
            // show the message on the chat container with loader
            let msg = userMsg(textarea.value);
            chatContainer.insertAdjacentHTML('beforeend', msg);
            scroolToBottom();
            // send the message to OpenAi api
            await new Promise((resolve, reject) => setTimeout(() => resolve(''), 500));
            // get the response from openAI
            let response =
                "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae earum, tempora incidunt quidem aliquid numquam quo suscipit cum, consequuntur sequi fugit nam molestias itaque quaerat libero adipisci temporibus atque id.";
            const ERROR = false;
            // remove loader 
            removeSpiner(ERROR);
            //show the reponse on the chat container 
            if (!ERROR) {
                let responseMsg = gptMsg(response);
                chatContainer.insertAdjacentHTML('beforeend', responseMsg);

            }
            // enable input  
            textarea.value = '';
            sendBtn.disabled = false;
            textarea.disabled = false;
            autoResize();
            countInput();
            scroolToBottom();

        }

        function removeSpiner(error = false) {

            let spiners = document.querySelectorAll(".spiner");
            for (let i = 0; i < spiners.length; i++) {
                const s = spiners[i];
                if (error) {

                    s.parentElement.parentElement.insertAdjacentHTML('beforeend',
                        " <span class='text-sm text-error'>Error !</span>");
                    s.parentElement.style.color = "red";
                }
                s.remove();
            }
        }



        function hundleInput(e) {

            countInput();
            autoResize();
        }


        function scroolToBottom() {
            chatContainer.scrollTo(0, chatContainer.scrollHeight);
        }

        function countInput() {
            if (textarea.value.length <= 0)
                sendBtn.disabled = true;
                else
                sendBtn.disabled = false;
            inputCounter.innerHTML = textarea.value.length + "/300"
        }

        function autoResize() {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";

        }

        function userMsg(message) {
            return `  
                <div class=" chat chat-end mb-3">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full bg-neutral-content  p-1">

                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" class="w-8 stroke-neutral-focus"
                                style="transform: scale(var(--grid-item-icon-scale));">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="chat-header">
                        <span class="text-xs opacity-50 mr-3">You</span>
                    </div>
                    <div class="chat-bubble relative">
                        ${message}
                         <div role="status"
                                class="spiner flex justify-center items-center absolute bg-white bg-opacity-50 top-0 left-0 right-0 bottom-0 chat-bubble w-full max-w-none">
                                <svg aria-hidden="true"
                                    class="w-8 h-8 mr-2 text-base-100 animate-spin  fill-primary-focus"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                    </div>
                </div>
                    `;
        }

        function gptMsg(message) {
            return `  
                <div class="chat chat-start mb-3">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full bg-neutral-content  p-1">
                            <svg fill="none" class="w-8 stroke-neutral-focus" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" class="h-32 w-32 "
                                style=" transform: scale(var(--grid-item-icon-scale));">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="chat-header">
                        <span class="text-xs opacity-50 ml-3">GPT</span>
                    </div>
                    <div class="chat-bubble">${message}</div>

                </div>
                    `;
        }
    </script>

    </html>
