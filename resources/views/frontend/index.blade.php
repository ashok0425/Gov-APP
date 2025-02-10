@extends('frontend.layout.master')
@section('content')

<main>
    <section class="hero">
      <div class="wrapper">
        <div class="hero-content">
          <h1 class="hero-title">
            <strong>Grow your business</strong> with web push notifications
          </h1>
          <div class="button-group">
            <button class="btn primary">Start free trial</button>
            <button class="btn link has-icon">
              <span>watch video</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <!-- <div class="container">
      </div> -->
    </section>

    <section class="section-space work-section">
      <div class="container">
        <div class="section-intro">
          <h1 class="section-title">How it works</h1>
          <p class="section-detail">
            Drive visitors back to your blog, personal or e-commerce site with
            targeted website push notifications.
          </p>
        </div>

        <div class="work-steps">
          <div class="step-wrapper">
            <div class="step-detail">
              <span class="step-count">step 1</span>
              <h2 class="step-title">Easy installation</h2>
              <p class="ste-detail">
                Install our lightweight tracking code with just a few lines of
                javascript or install our Wordpress or Shopify plugin and get
                set up with just a few clicks!
              </p>
            </div>
            <div class="step-image">
              <img src="public/installation.png" alt="" />
            </div>
          </div>

          <div class="step-wrapper">
            <div class="step-detail">
              <span class="step-count">step 2</span>
              <h2 class="step-title">Acquire Subscribers</h2>
              <p class="ste-detail">
                Group your subscribers into custom segments, enabling you to
                send your message to exactly the right audience. Mix, match
                and combine any combination of recorded actions.
              </p>
            </div>
            <div class="step-image">
              <img src="public/subscribe.png" alt="" />
            </div>
          </div>

          <div class="step-wrapper">
            <div class="step-detail">
              <span class="step-count">step 3</span>
              <h2 class="step-title">Engage Clients</h2>
              <p class="ste-detail">
                Your notifications are instantly delivered to all of your
                subscribers on desktop or their mobile devices which - when
                clicked - drive them back to your website.
              </p>
            </div>
            <div class="step-image">
              <img src="public/engage.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-space support-section">
      <div class="container">
        <div class="section-intro">
          <h1 class="section-title">Support</h1>
          <p class="section-detail">
            Supported on every push enabled browsers, including:
          </p>
        </div>

        <div class="supported-browser">
          <img src="public/android.svg" alt="support android" />
          <img src="public/firefox.svg" alt="support firefox" />
          <img src="public/safari.svg" alt="support safari" />
        </div>

        <button class="btn primary" style="--btn-bg: var(--color-secondary)">
          start free trial
        </button>
      </div>
    </section>

    <section class="section-space feature-section">
      <div class="container">
        <div class="section-intro">
          <h1 class="section-title">Features you'll love</h1>
          <p class="section-detail">
            Drive visitors back to your blog, personal or e-commerce site with
            targeted website push notifications.
          </p>
        </div>

        <div class="features-tab">
          <div class="tab-list">
            <div data-active="true" class="tab-trigger">
              <div class="trigger-display">
                <svg
                  fill="#000000"
                  width="180px"
                  height="180px"
                  viewBox="0 0 1024 1024"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M85.333 512C85.333 276.358 276.358 85.333 512 85.333c235.639 0 426.667 191.025 426.667 426.667 0 235.639-191.027 426.667-426.667 426.667C276.358 938.667 85.333 747.64 85.333 512zM512 128c-212.077 0-384 171.923-384 384 0 142.135 77.222 266.231 192 332.629V628.62c0-77.474 45.885-144.23 111.962-174.575-38.129-25.737-63.201-69.344-63.201-118.808 0-79.108 64.131-143.238 143.24-143.238s143.236 64.13 143.236 143.238c0 49.463-25.071 93.071-63.202 118.808 66.078 30.345 111.966 97.101 111.966 174.575v216.009c114.778-66.398 192-190.494 192-332.629 0-212.077-171.921-384-384-384zm149.333 737.882V628.621c0-82.475-66.859-149.333-149.333-149.333s-149.333 66.859-149.333 149.333v237.261C408.572 885.278 459.034 896 512 896s103.428-10.722 149.333-30.118zM512 234.667c-55.543 0-100.573 45.027-100.573 100.571S456.457 435.81 512 435.81c55.543 0 100.57-45.028 100.57-100.572S567.544 234.667 512 234.667z" />
                </svg>

                <h5 class="trigger-title">Lead Data Enrichment</h5>

                <svg
                  width="18px"
                  height="18px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <g id="Arrow / Arrow_Right_LG">
                    <path
                      id="Vector"
                      d="M21 12L16 7M21 12L16 17M21 12H3"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </g>
                </svg>
              </div>

              <p class="trigger-detail">
                You can search through subscribers and find anyone who matches
                a mix of criteria from the above collected data.
              </p>
            </div>

            <div data-active="false" class="tab-trigger">
              <div class="trigger-display">
                <svg
                  width="800px"
                  height="800px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M21.2995 7.57969H15.7195C15.3295 7.57969 15.0195 7.26969 15.0195 6.87969C15.0195 6.48969 15.3295 6.17969 15.7195 6.17969H21.2995C21.6895 6.17969 21.9995 6.48969 21.9995 6.87969C21.9995 7.26969 21.6895 7.57969 21.2995 7.57969Z"
                    fill="#292D32" />
                  <path
                    d="M6.42 7.57969H2.7C2.31 7.57969 2 7.26969 2 6.87969C2 6.48969 2.31 6.17969 2.7 6.17969H6.42C6.81 6.17969 7.12 6.48969 7.12 6.87969C7.12 7.26969 6.8 7.57969 6.42 7.57969Z"
                    fill="#292D32" />
                  <path
                    d="M10.1395 10.8297C12.321 10.8297 14.0895 9.06121 14.0895 6.87969C14.0895 4.69816 12.321 2.92969 10.1395 2.92969C7.95793 2.92969 6.18945 4.69816 6.18945 6.87969C6.18945 9.06121 7.95793 10.8297 10.1395 10.8297Z"
                    fill="#292D32" />
                  <path
                    d="M21.3009 17.8102H17.5809C17.1909 17.8102 16.8809 17.5002 16.8809 17.1102C16.8809 16.7202 17.1909 16.4102 17.5809 16.4102H21.3009C21.6909 16.4102 22.0009 16.7202 22.0009 17.1102C22.0009 17.5002 21.6909 17.8102 21.3009 17.8102Z"
                    fill="#292D32" />
                  <path
                    d="M8.28 17.8102H2.7C2.31 17.8102 2 17.5002 2 17.1102C2 16.7202 2.31 16.4102 2.7 16.4102H8.28C8.67 16.4102 8.98 16.7202 8.98 17.1102C8.98 17.5002 8.66 17.8102 8.28 17.8102Z"
                    fill="#292D32" />
                  <path
                    d="M13.8602 21.0719C16.0417 21.0719 17.8102 19.3034 17.8102 17.1219C17.8102 14.9404 16.0417 13.1719 13.8602 13.1719C11.6786 13.1719 9.91016 14.9404 9.91016 17.1219C9.91016 19.3034 11.6786 21.0719 13.8602 21.0719Z"
                    fill="#292D32" />
                </svg>
                <h5 class="trigger-title">Advanced Segmentation</h5>
                <svg
                  width="18px"
                  height="18px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <g id="Arrow / Arrow_Right_LG">
                    <path
                      id="Vector"
                      d="M21 12L16 7M21 12L16 17M21 12H3"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </g>
                </svg>
              </div>

              <p class="trigger-detail">
                You can search through subscribers and find anyone who matches
                a mix of criteria from the above collected data.
              </p>
            </div>

            <div data-active="false" class="tab-trigger">
              <div class="trigger-display">
                <svg
                  fill="#000000"
                  width="800px"
                  height="800px"
                  viewBox="0 0 30 30"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M22.5 15c-.822 0-1.5.678-1.5 1.5v.785c-.393.114-.77.267-1.13.465l-.313-.314c-.582-.582-1.54-.582-2.12 0-.583.58-.583 1.54 0 2.12l.313.315c-.2.36-.354.736-.47 1.13h-.78c-.822 0-1.5.678-1.5 1.5s.678 1.5 1.5 1.5h.785c.114.393.267.77.465 1.13l-.314.313c-.582.582-.582 1.54 0 2.12.58.583 1.54.583 2.12 0l.315-.313c.36.2.736.354 1.13.47v.78c0 .822.678 1.5 1.5 1.5s1.5-.678 1.5-1.5v-.785c.393-.114.77-.267 1.13-.465l.313.314c.582.582 1.54.582 2.12 0 .583-.58.583-1.54 0-2.12l-.313-.315c.2-.36.354-.736.47-1.13h.78c.822 0 1.5-.678 1.5-1.5s-.678-1.5-1.5-1.5h-.785c-.114-.393-.267-.77-.465-1.13l.314-.313c.582-.582.582-1.54 0-2.12-.58-.583-1.54-.583-2.12 0l-.315.313c-.36-.2-.736-.354-1.13-.47v-.78c0-.822-.678-1.5-1.5-1.5zm0 1c.286 0 .5.214.5.5v1c0 .328.084.508.38.588.57.115 1.112.34 1.597.66.198.132.462.106.63-.062l.543-.543c.202-.202.505-.202.707 0 .202.202.202.505 0 .707l-.543.543c-.168.167-.195.43-.064.628.32.486.544 1.028.658 1.597.08.302.344.383.592.383h1c.286 0 .5.214.5.5 0 .286-.214.5-.5.5h-1c-.394 0-.528.158-.588.38-.115.57-.34 1.112-.66 1.597-.132.198-.106.462.062.63l.543.543c.202.202.202.505 0 .707-.202.202-.505.202-.707 0l-.543-.543c-.167-.168-.43-.195-.628-.064-.486.32-1.028.544-1.597.658-.264.07-.383.34-.383.592v1c0 .286-.214.5-.5.5-.286 0-.5-.214-.5-.5v-1c0-.37-.138-.523-.38-.588-.57-.115-1.112-.34-1.597-.66-.198-.132-.462-.106-.63.062l-.543.543c-.202.202-.505.202-.707 0-.202-.202-.202-.505 0-.707l.543-.543c.168-.167.195-.43.064-.628-.32-.486-.544-1.028-.658-1.597-.05-.252-.262-.383-.592-.383h-1c-.286 0-.5-.214-.5-.5 0-.286.214-.5.5-.5h1c.445 0 .524-.143.588-.38.115-.57.34-1.112.66-1.597.132-.198.106-.462-.062-.63l-.543-.543c-.202-.202-.202-.505 0-.707.202-.202.505-.202.707 0l.543.543c.167.168.43.195.628.064.486-.32 1.028-.544 1.597-.658.402-.092.383-.406.383-.592v-1c0-.286.214-.5.5-.5zm0 4c-1.375 0-2.5 1.125-2.5 2.5s1.125 2.5 2.5 2.5 2.5-1.125 2.5-2.5-1.125-2.5-2.5-2.5zm0 1c.834 0 1.5.666 1.5 1.5s-.666 1.5-1.5 1.5-1.5-.666-1.5-1.5.666-1.5 1.5-1.5zm-10-13C10.02 8 8 10.02 8 12.5s2.02 4.5 4.5 4.5 4.5-2.02 4.5-4.5S14.98 8 12.5 8zm0 1c1.94 0 3.5 1.56 3.5 3.5S14.44 16 12.5 16 9 14.44 9 12.5 10.56 9 12.5 9zm-1-9c-.822 0-1.5.678-1.5 1.5v1.91c-.763.21-1.494.51-2.182.9L5.943 2.437c-.582-.582-1.54-.582-2.123 0L2.406 3.85c-.58.58-.58 1.54 0 2.12l1.887 1.887c-.382.677-.68 1.394-.887 2.143H1.5c-.822 0-1.5.678-1.5 1.5v2c0 .822.678 1.5 1.5 1.5h1.908c.207.757.507 1.48.893 2.164l-1.894 1.893c-.582.582-.582 1.54 0 2.123l1.414 1.414c.582.582 1.54.582 2.123 0l1.897-1.9c.68.39 1.404.69 2.16.898V23.5c0 .822.678 1.5 1.5 1.5h2c.664 0 .66-1 0-1h-2c-.286 0-.5-.214-.5-.5v-2.234c0-.234-.16-.437-.39-.49-.93-.212-1.82-.58-2.63-1.09-.196-.124-.452-.095-.617.068l-.006.01-.003.004-2.118 2.12c-.2.2-.507.2-.71 0l-1.413-1.415c-.2-.202-.2-.508 0-.71l2.123-2.12.004-.004.002-.003c.162-.165.19-.42.067-.616-.508-.81-.874-1.7-1.085-2.63-.052-.23-.255-.39-.49-.39H1.5c-.286 0-.5-.214-.5-.5v-2c0-.286.214-.5.5-.5h2.234c.234 0 .437-.16.49-.39.21-.923.574-1.806 1.077-2.61.125-.198.095-.454-.07-.62L3.113 5.265c-.202-.202-.202-.505 0-.707l1.414-1.414c.202-.202.508-.202.71 0L7.34 5.248c.165.165.42.194.62.07.814-.512 1.71-.88 2.647-1.093.228-.052.39-.255.39-.49V1.5c0-.286.214-.5.5-.5h2c.286 0 .5.214.5.5v2.234c0 .234.16.437.39.49.93.212 1.817.58 2.626 1.089.197.123.454.094.62-.07l2.1-2.1c.202-.202.505-.202.707 0l1.414 1.414c.202.202.202.505 0 .707L19.764 7.36c-.165.164-.194.42-.07.62.506.81.87 1.697 1.08 2.63.053.228.256.39.49.39H23.5c.286 0 .5.214.5.5v2c0 .668 1 .652 1 0v-2c0-.822-.678-1.5-1.5-1.5h-1.908c-.207-.756-.505-1.48-.89-2.164l1.862-1.865c.582-.58.582-1.54 0-2.12L21.15 2.436c-.58-.582-1.54-.582-2.12 0l-1.87 1.87c-.68-.39-1.405-.69-2.16-.898V1.5c0-.822-.678-1.5-1.5-1.5z" />
                </svg>
                <h5 class="trigger-title">Automation & Triggers</h5>
                <svg
                  width="18px"
                  height="18px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <g id="Arrow / Arrow_Right_LG">
                    <path
                      id="Vector"
                      d="M21 12L16 7M21 12L16 17M21 12H3"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </g>
                </svg>
              </div>

              <p class="trigger-detail">
                You can search through subscribers and find anyone who matches
                a mix of criteria from the above collected data.
              </p>
            </div>

            <div data-active="false" class="tab-trigger">
              <div class="trigger-display">
                <svg
                  width="800px"
                  height="800px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M18.9553 1.25C18.5224 1.24995 18.1256 1.24991 17.8028 1.29331C17.4473 1.3411 17.0716 1.45355 16.7626 1.76257C16.4535 2.07159 16.3411 2.44732 16.2933 2.8028C16.2499 3.12561 16.25 3.52244 16.25 3.95525V17.0448C16.25 17.4776 16.2499 17.8744 16.2933 18.1972C16.3411 18.5527 16.4535 18.9284 16.7626 19.2374C17.0716 19.5465 17.4473 19.6589 17.8028 19.7067C18.1256 19.7501 18.5224 19.7501 18.9553 19.75H19.0448C19.4776 19.7501 19.8744 19.7501 20.1972 19.7067C20.5527 19.6589 20.9284 19.5465 21.2374 19.2374C21.5465 18.9284 21.6589 18.5527 21.7067 18.1972C21.7501 17.8744 21.7501 17.4776 21.75 17.0448V3.95526C21.7501 3.52245 21.7501 3.12561 21.7067 2.8028C21.6589 2.44732 21.5465 2.07159 21.2374 1.76257C20.9284 1.45355 20.5527 1.3411 20.1972 1.29331C19.8744 1.24991 19.4776 1.24995 19.0448 1.25H18.9553ZM17.8257 2.82187L17.8232 2.82324L17.8219 2.82568C17.8209 2.82761 17.8192 2.83093 17.8172 2.83597C17.8082 2.85775 17.7929 2.90611 17.7799 3.00267C17.7516 3.21339 17.75 3.5074 17.75 4.00001V17C17.75 17.4926 17.7516 17.7866 17.7799 17.9973C17.7929 18.0939 17.8082 18.1423 17.8172 18.164C17.8192 18.1691 17.8209 18.1724 17.8219 18.1743L17.8232 18.1768L17.8257 18.1781C17.8265 18.1786 17.8276 18.1791 17.8289 18.1797C17.8307 18.1806 17.8331 18.1817 17.836 18.1828C17.8578 18.1918 17.9061 18.2071 18.0027 18.2201C18.2134 18.2484 18.5074 18.25 19 18.25C19.4926 18.25 19.7866 18.2484 19.9973 18.2201C20.0939 18.2071 20.1423 18.1918 20.164 18.1828C20.1691 18.1808 20.1724 18.1792 20.1743 18.1781L20.1768 18.1768L20.1781 18.1743C20.1792 18.1724 20.1808 18.1691 20.1828 18.164C20.1918 18.1423 20.2071 18.0939 20.2201 17.9973C20.2484 17.7866 20.25 17.4926 20.25 17V4.00001C20.25 3.5074 20.2484 3.21339 20.2201 3.00267C20.2071 2.90611 20.1918 2.85775 20.1828 2.83597C20.1808 2.83093 20.1792 2.82761 20.1781 2.82568L20.1768 2.82324L20.1743 2.82187C20.1724 2.82086 20.1691 2.81924 20.164 2.81717C20.1423 2.80821 20.0939 2.79291 19.9973 2.77993C19.7866 2.7516 19.4926 2.75001 19 2.75001C18.5074 2.75001 18.2134 2.7516 18.0027 2.77993C17.9061 2.79291 17.8578 2.80821 17.836 2.81717C17.8309 2.81924 17.8276 2.82086 17.8257 2.82187Z"
                    fill="#1C274C" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M11.9553 4.25H12.0448C12.4776 4.24995 12.8744 4.24991 13.1972 4.29331C13.5527 4.3411 13.9284 4.45355 14.2374 4.76257C14.5465 5.07159 14.6589 5.44732 14.7067 5.8028C14.7501 6.12561 14.7501 6.52243 14.75 6.95524V17.0448C14.7501 17.4776 14.7501 17.8744 14.7067 18.1972C14.6589 18.5527 14.5465 18.9284 14.2374 19.2374C13.9284 19.5465 13.5527 19.6589 13.1972 19.7067C12.8744 19.7501 12.4776 19.7501 12.0448 19.75H11.9553C11.5225 19.7501 11.1256 19.7501 10.8028 19.7067C10.4473 19.6589 10.0716 19.5465 9.76257 19.2374C9.45355 18.9284 9.3411 18.5527 9.29331 18.1972C9.24991 17.8744 9.24995 17.4776 9.25 17.0448V6.95526C9.24995 6.52244 9.24991 6.12561 9.29331 5.8028C9.3411 5.44732 9.45355 5.07159 9.76257 4.76257C10.0716 4.45355 10.4473 4.3411 10.8028 4.29331C11.1256 4.24991 11.5224 4.24995 11.9553 4.25ZM10.8232 5.82324L10.8257 5.82187L10.8234 18.1768L10.8219 18.1743C10.8209 18.1724 10.8192 18.1691 10.8172 18.164C10.8082 18.1423 10.7929 18.0939 10.7799 17.9973C10.7516 17.7866 10.75 17.4926 10.75 17V7.00001C10.75 6.5074 10.7516 6.21339 10.7799 6.00267C10.7929 5.90611 10.8082 5.85775 10.8172 5.83597C10.8192 5.83093 10.8209 5.82761 10.8219 5.82568L10.8232 5.82324ZM10.8234 18.1768L10.8257 5.82187L10.8295 5.81999L10.836 5.81717C10.8578 5.80821 10.9061 5.79291 11.0027 5.77993C11.2134 5.7516 11.5074 5.75001 12 5.75001C12.4926 5.75001 12.7866 5.7516 12.9973 5.77993C13.0939 5.79291 13.1423 5.80821 13.164 5.81717C13.1691 5.81924 13.1724 5.82086 13.1743 5.82187L13.1768 5.82324L13.1781 5.82568C13.1792 5.82761 13.1808 5.83093 13.1828 5.83597C13.1918 5.85775 13.2071 5.90611 13.2201 6.00267C13.2484 6.21339 13.25 6.5074 13.25 7.00001V17C13.25 17.4926 13.2484 17.7866 13.2201 17.9973C13.2071 18.0939 13.1918 18.1423 13.1828 18.164C13.1808 18.1691 13.1792 18.1724 13.1781 18.1743L13.1768 18.1768L13.1743 18.1781C13.1731 18.1788 13.1712 18.1797 13.1686 18.1809C13.1673 18.1815 13.1658 18.1821 13.164 18.1828C13.1423 18.1918 13.0939 18.2071 12.9973 18.2201C12.7866 18.2484 12.4926 18.25 12 18.25C11.5074 18.25 11.2134 18.2484 11.0027 18.2201C10.9061 18.2071 10.8578 18.1918 10.836 18.1828C10.8309 18.1808 10.8276 18.1792 10.8257 18.1781L10.8234 18.1768Z"
                    fill="#1C274C" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M4.95526 8.25C4.52244 8.24995 4.12561 8.24991 3.8028 8.29331C3.44732 8.3411 3.07159 8.45355 2.76257 8.76257C2.45355 9.07159 2.3411 9.44732 2.29331 9.8028C2.24991 10.1256 2.24995 10.5224 2.25 10.9553V17.0448C2.24995 17.4776 2.24991 17.8744 2.29331 18.1972C2.3411 18.5527 2.45355 18.9284 2.76257 19.2374C3.07159 19.5465 3.44732 19.6589 3.8028 19.7067C4.12561 19.7501 4.52245 19.7501 4.95526 19.75H5.04475C5.47757 19.7501 5.8744 19.7501 6.19721 19.7067C6.5527 19.6589 6.92842 19.5465 7.23744 19.2374C7.54647 18.9284 7.65891 18.5527 7.70671 18.1972C7.75011 17.8744 7.75006 17.4776 7.75001 17.0448V10.9553C7.75006 10.5224 7.75011 10.1256 7.70671 9.8028C7.65891 9.44732 7.54647 9.07159 7.23744 8.76257C6.92842 8.45355 6.5527 8.3411 6.19721 8.29331C5.8744 8.24991 5.47757 8.24995 5.04476 8.25H4.95526ZM3.82568 9.82187L3.82324 9.82324L3.82187 9.82568C3.82086 9.82761 3.81924 9.83093 3.81717 9.83597C3.80821 9.85775 3.79291 9.90611 3.77993 10.0027C3.7516 10.2134 3.75001 10.5074 3.75001 11V17C3.75001 17.4926 3.7516 17.7866 3.77993 17.9973C3.79291 18.0939 3.80821 18.1423 3.81717 18.164C3.81924 18.1691 3.82086 18.1724 3.82187 18.1743L3.82284 18.1761L3.82568 18.1781C3.82761 18.1792 3.83093 18.1808 3.83597 18.1828C3.85775 18.1918 3.90611 18.2071 4.00267 18.2201C4.21339 18.2484 4.5074 18.25 5.00001 18.25C5.49261 18.25 5.78662 18.2484 5.99734 18.2201C6.0939 18.2071 6.14226 18.1918 6.16404 18.1828C6.16909 18.1808 6.1724 18.1792 6.17434 18.1781L6.17677 18.1768L6.17815 18.1743L6.18036 18.1698L6.18285 18.164C6.19181 18.1423 6.2071 18.0939 6.22008 17.9973C6.24841 17.7866 6.25001 17.4926 6.25001 17V11C6.25001 10.5074 6.24841 10.2134 6.22008 10.0027C6.2071 9.90611 6.19181 9.85775 6.18285 9.83597C6.18077 9.83093 6.17916 9.82761 6.17815 9.82568L6.17677 9.82324L6.17434 9.82187C6.1724 9.82086 6.16909 9.81924 6.16404 9.81717C6.14226 9.8082 6.0939 9.79291 5.99734 9.77993C5.78662 9.7516 5.49261 9.75001 5.00001 9.75001C4.5074 9.75001 4.21339 9.7516 4.00267 9.77993C3.90611 9.79291 3.85775 9.8082 3.83597 9.81717C3.83093 9.81924 3.82761 9.82086 3.82568 9.82187Z"
                    fill="#1C274C" />
                  <path
                    d="M3.00001 21.25C2.58579 21.25 2.25001 21.5858 2.25001 22C2.25001 22.4142 2.58579 22.75 3.00001 22.75H21C21.4142 22.75 21.75 22.4142 21.75 22C21.75 21.5858 21.4142 21.25 21 21.25H3.00001Z"
                    fill="#1C274C" />
                </svg>
                <h5 class="trigger-title">Rich Reporting</h5>
                <svg
                  width="18px"
                  height="18px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <g id="Arrow / Arrow_Right_LG">
                    <path
                      id="Vector"
                      d="M21 12L16 7M21 12L16 17M21 12H3"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round" />
                  </g>
                </svg>
              </div>
              <p class="trigger-detail">
                You can search through subscribers and find anyone who matches
                a mix of criteria from the above collected data.
              </p>
            </div>
          </div>

          <div class="tab-content">
            <img src="public/features.png" alt="" />
          </div>
        </div>

        <button class="btn primary" style="--btn-bg: var(--color-secondary)">
          start free trial
        </button>
      </div>
    </section>

    <section class="section-space testimonial-section">
      <div class="container">
        <div class="section-intro">
          <h1 class="section-title">Trusted by thousands</h1>
          <p class="section-detail">
            Drive visitors back to your blog, personal or e-commerce site with
            targeted website push notifications.
          </p>
        </div>

        <!-- <div class="trustee-logos">
          <img src="public/clay-games.svg" alt="clay-games" />
        </div> -->

        <div thumbsSlider="" class="trustee-logos swiper mySwiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="public/marvel.svg" alt="marvel" />
            </div>
            <div class="swiper-slide">
              <img src="public/sony.svg" alt="sony" />
            </div>
            <div class="swiper-slide">
              <img src="public/cs.svg" alt="cs" />
            </div>
          </div>
        </div>

        <div class="swiper testimonials">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <blockquote>
                <p>
                  Highly recommended.Without a doubt the best push notificatin
                  provider we've tried. Their segmentation and automation
                  features are incredible. Being able to automatically send
                  notifications to abandoned carts is fantastic. This has got
                  to be my favourite app hands down.
                </p>
              </blockquote>
              <div class="testimonial-by">
                <img
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                  alt="man" />
                <div class="details">
                  <p class="name">Alan Watts, CTO</p>
                  <small>Hubspot</small>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <blockquote>
                <p>
                  Highly recommended.Without a doubt the best push notificatin
                  provider we've tried. Their segmentation and automation
                  features are incredible. Being able to automatically send
                  notifications to abandoned carts is fantastic. This has got
                  to be my favourite app hands down.
                </p>
              </blockquote>
              <div class="testimonial-by">
                <img
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                  alt="man" />
                <div class="details">
                  <p class="name">Alan Watts, CTO</p>
                  <small>Hubspot</small>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <blockquote>
                <p>
                  Highly recommended.Without a doubt the best push notificatin
                  provider we've tried. Their segmentation and automation
                  features are incredible. Being able to automatically send
                  notifications to abandoned carts is fantastic. This has got
                  to be my favourite app hands down.
                </p>
              </blockquote>
              <div class="testimonial-by">
                <img
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                  alt="man" />
                <div class="details">
                  <p class="name">Alan Watts, CTO</p>
                  <small>Hubspot</small>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </section>

    <section class="section-space cta-section">
      <div class="container">
        <div class="section-intro">
          <h1 class="section-title">
            Begin sending web push within minutes!
          </h1>
          <p class="section-detail">
            Drive visitors back to your blog, personal or e-commerce site with
            targeted website push notifications.
          </p>
        </div>
        <button
          class="btn primary"
          style="--btn-bg: #fff; --btn-text-color: var(--color-primary)">
          start free trial
        </button>
      </div>
    </section>
  </main>

@endsection
