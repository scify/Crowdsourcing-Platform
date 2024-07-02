<meta name="keywords" content="{{ $viewModel->keywords }}">
<meta name="description" content="{{ $viewModel->description }}">
<!--FACEBOOK-->
<meta property="og:title" content="{{ $viewModel->title }}">
<meta property="og:description" content="{{ $viewModel->description }}">
<meta property="og:site_name" content="{{ $viewModel->siteName }}">
<meta property="og:image" content="{{ asset($viewModel->featuredImgPath) }}">
<!--TWITTER-->
<meta property="twitter:title" content="{{ $viewModel->title }}">
<meta property="twitter:description" content="{{ $viewModel->description }}">
<meta property="twitter:image:alt" content="{{ $viewModel->title }}">
<meta property="twitter:image" content="{{ asset($viewModel->featuredImgPath) }}">
