# Backoffice BS5 Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove AdminLTE, rebuild the backoffice shell as custom Bootstrap 5 SCSS, and migrate the whole site from Bootstrap 4 to Bootstrap 5.

**Architecture:** Pre-swap the plugins that Bootstrap 5 breaks while still on Bootstrap 4 (each swap stays green). Then do one atomic core swap: Bootstrap 5 + AdminLTE removal + new shell. Then mechanical markup migration, JS API conversions, and a full visual verification against a screenshot baseline.

**Tech Stack:** Laravel 12 Blade, Bootstrap 5.3, Sass, Vite 8, jQuery 3.7 (kept), Vue 3 SFCs, DataTables 2, sweetalert2, Coloris.

**Spec:** `docs/superpowers/specs/2026-09-01-backoffice-bs5-redesign-design.md`

## Global Constraints

- Branch: all work happens on `feature/backoffice-bs5-redesign`.
- jQuery stays at `^3.7.1`. Do NOT remove jQuery or convert non-Bootstrap jQuery code.
- Font Awesome stays at `^5.15.4`. Do NOT bump it.
- SurveyJS packages (`survey-*`) are untouchable in this plan.
- DataTables: `-bs4` styling packages change to `-bs5`; the logic packages (`-buttons`, `-responsive`, `-select`) bump to the versions the `-bs5` packages require (`-buttons@^4.0.2`, `-responsive@^4.0.2`, `-select@^4.0.1`). `datatables.net` core stays on its `^2.x` line.
- Bootstrap target: `^5.3.8`.
- JS/SCSS indentation in this repo is tabs; Blade uses 4 spaces. Match existing style.
- After every task: `npm run build` must complete without errors, then commit.
- A pre-commit hook runs on commit; if it modifies files, re-stage and re-commit.
- The dev server runs at `http://127.0.0.1:8000/en`. Admin login: `platform-admin@crowd.com`, password = `DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED` in `.env`.
- Screenshot baseline dir: `docs/superpowers/plans/baseline-screenshots/` (git-ignored; add to `.gitignore` in Task 1).

---

### Task 1: Capture the visual baseline

Performed by the MAIN session (needs browser tools), not a subagent.

**Files:**
- Create: `docs/superpowers/plans/baseline-screenshots/` (directory, git-ignored)
- Modify: `.gitignore` (add `docs/superpowers/plans/baseline-screenshots/`)

- [ ] **Step 1: Add the screenshots dir to .gitignore and commit**

```bash
echo "docs/superpowers/plans/baseline-screenshots/" >> .gitignore
git add .gitignore && git commit -m "chore: ignore baseline screenshots dir"
```

- [ ] **Step 2: Log in and capture every page**

Log in at `http://127.0.0.1:8000/login` with the admin credentials. Capture full-page screenshots, named `before-<slug>.png`, of:

1. `/login` (before logging in)
2. Backoffice: projects index, project create, project edit (first project), questionnaires all, questionnaire responses/reports, problems index, problem create, solutions index, manage users, MailChimp page, my-dashboard, my-contributions
3. Public: home, one project landing page, one public questionnaire page, one problem page, one solution page

Also capture the backoffice at 375px width (mobile) for: projects index, manage users.

- [ ] **Step 3: Verify all screenshots exist and are non-empty**

Run: `ls -la docs/superpowers/plans/baseline-screenshots/ | wc -l`
Expected: at least 19 files.

---

### Task 2: Remove dead packages

**Files:**
- Modify: `package.json`
- Modify: `resources/assets/js/common-backoffice.js:3,6` (remove `fastclick` and `jquery-slimscroll` imports)

**Interfaces:**
- Produces: `common-backoffice.js` no longer imports `fastclick` or `jquery-slimscroll`. Later tasks rewrite this file further.

- [ ] **Step 1: Verify the packages are truly unused**

```bash
grep -rn "fastclick\|slimscroll\|sparkline" resources/ --include="*.js" --include="*.vue" --include="*.scss" --include="*.blade.php"
```

Expected: only the two import lines in `resources/assets/js/common-backoffice.js` (lines 3 and 6). If anything else appears, STOP and report.

- [ ] **Step 2: Remove the imports and packages**

Delete these two lines from `resources/assets/js/common-backoffice.js`:

```js
import "fastclick";
import "jquery-slimscroll";
```

```bash
npm uninstall fastclick jquery-slimscroll jquery-sparkline
```

- [ ] **Step 3: Build and verify**

Run: `npm run build`
Expected: completes with exit code 0.

- [ ] **Step 4: Commit**

```bash
git add package.json package-lock.json resources/assets/js/common-backoffice.js
git commit -m "chore: remove unused fastclick, jquery-slimscroll, jquery-sparkline"
```

---

### Task 3: Replace icheck with native checkboxes

**Files:**
- Modify: `resources/assets/js/common-backoffice.js` (remove icheck import + `initializeIcheck`)
- Modify: `resources/assets/sass/common.scss:7` (remove icheck skin import)
- Modify: `resources/views/auth/login.blade.php`
- Modify: `resources/views/backoffice/management/crowdsourcing-project/create-edit/partials/landing-page.blade.php:251`
- Modify: `resources/views/backoffice/management/crowdsourcing-project/create-edit/partials/communication-resources.blade.php:10`
- Modify: `package.json`

- [ ] **Step 1: Find every icheck usage**

```bash
grep -rn "icheck\|iCheck" resources/ --include="*.js" --include="*.vue" --include="*.scss" --include="*.blade.php"
```

Expected: the files listed above and nothing else. If more appear, convert them with the same pattern below.

- [ ] **Step 2: Convert the markup**

In each Blade file, an icheck checkbox looks like:

```html
<input type="checkbox" class="icheck-input" name="remember" ...>
```

Convert to plain Bootstrap checkbox markup (works in BS4 now and BS5 later). Wrap input+label in the standard structure and drop the `icheck-input` class:

```html
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="remember" id="remember" ...>
    <label class="form-check-label" for="remember">...</label>
</div>
```

Keep every existing `name`, `id`, `value`, `checked` attribute and wire each label's `for` to the input `id` (add an `id` if missing).

- [ ] **Step 3: Remove the JS and CSS**

In `resources/assets/js/common-backoffice.js`: delete `import "icheck";` (line 1), the whole `initializeIcheck` function (lines 24-30), and its call inside `$(document).ready` (line 102).

In `resources/assets/sass/common.scss`: delete line 7:

```scss
@import url("../../../node_modules/icheck/skins/square/blue.css");
```

```bash
npm uninstall icheck
```

- [ ] **Step 4: Build, verify in browser, commit**

Run: `npm run build` — expected exit 0.
Verify: open `/login`; the remember-me checkbox renders and toggles.

```bash
git add -A && git commit -m "refactor: replace icheck with native form-check markup"
```

---

### Task 4: Replace bootstrap-sweetalert with sweetalert2

**Files:**
- Modify: `resources/assets/js/questionnaire/questionnaire-reports.js:79`
- Modify: `resources/assets/js/vue-components/questionnaire/QuestionnaireDisplay.vue:398`
- Modify: `resources/assets/js/vue-components/questionnaire/QuestionnaireCreateEdit.vue:553,617,637,653`
- Modify: `resources/assets/sass/common.scss:9`
- Modify: `package.json`

- [ ] **Step 1: Install sweetalert2, remove bootstrap-sweetalert**

```bash
npm uninstall bootstrap-sweetalert && npm install sweetalert2
```

- [ ] **Step 2: Convert every call site**

Find them: `grep -rn "bootstrap-sweetalert\|swal(" resources/assets/js`

The old library is called as `swal({...}, callback)`. Convert with this exact mapping — `import Swal from "sweetalert2";` replaces the old import (keep lazy `import(...)` style where the current code lazy-imports):

| bootstrap-sweetalert | sweetalert2 |
|---|---|
| `type: "warning"` | `icon: "warning"` |
| `confirmButtonText`, `cancelButtonText`, `title`, `text`, `showCancelButton` | same names |
| `closeOnConfirm: false` | `allowOutsideClick: false` + call `Swal.close()` manually |
| `swal({...}, function (confirmed) { if (confirmed) ... })` | `Swal.fire({...}).then((result) => { if (result.isConfirmed) ... })` |

Example — before:

```js
swal({
    title: "Are you sure?",
    text: "This response will be deleted.",
    type: "warning",
    showCancelButton: true,
}, function (confirmed) {
    if (confirmed) deleteResponse(id);
});
```

After:

```js
Swal.fire({
    title: "Are you sure?",
    text: "This response will be deleted.",
    icon: "warning",
    showCancelButton: true,
}).then((result) => {
    if (result.isConfirmed) deleteResponse(id);
});
```

- [ ] **Step 3: Swap the CSS import**

In `resources/assets/sass/common.scss`, replace line 9:

```scss
@import "../../../node_modules/bootstrap-sweetalert/dist/sweetalert.css";
```

with:

```scss
@import "../../../node_modules/sweetalert2/dist/sweetalert2.min.css";
```

- [ ] **Step 4: Build, verify, commit**

Run: `npm run build` — expected exit 0.
Verify in browser: in the backoffice questionnaire edit page, trigger a delete confirmation; the sweetalert2 dialog opens, Cancel and Confirm both work.

```bash
git add -A && git commit -m "refactor: replace bootstrap-sweetalert with sweetalert2"
```

---

### Task 5: Replace bootstrap-colorpicker with Coloris

**Files:**
- Modify: `resources/assets/js/questionnaire/questionnaire-statistics-colors.js`
- Modify: `resources/assets/js/vue-components/backoffice/management/crowd-sourcing-project/CrowdSourcingProjectColors.vue`
- Modify: `resources/assets/sass/questionnaire/questionnaire-statistics-colors.scss:1`
- Modify: `resources/assets/sass/common.scss` (`.color-picker .input-group-addon` rule, ~line 307 — update selector if the markup changes)
- Modify: `package.json`

- [ ] **Step 1: Install Coloris, remove bootstrap-colorpicker**

```bash
npm uninstall bootstrap-colorpicker && npm install @melloware/coloris
```

- [ ] **Step 2: Convert both init sites**

Read both files first. The old pattern is:

```js
$(".color-picker").colorpicker({ format: "hex" });
$(".color-picker").on("colorpickerChange", (e) => { /* uses e.color.toString() */ });
```

New pattern (Coloris binds to `<input>` elements, not wrappers):

```js
import Coloris from "@melloware/coloris";
Coloris.init();
Coloris({ el: ".color-picker-input", format: "hex" });
document.querySelectorAll(".color-picker-input").forEach((input) => {
    input.addEventListener("input", (e) => { /* e.target.value is the hex string */ });
});
```

Adjust the corresponding Blade/Vue markup so each picker is a text `<input class="color-picker-input">` with its current hex value as `value`. Keep all surrounding logic (what happens with the chosen color) identical.

- [ ] **Step 3: Swap the CSS import**

In `resources/assets/sass/questionnaire/questionnaire-statistics-colors.scss`, replace the bootstrap-colorpicker import (line 1) with:

```scss
@import "../../../../node_modules/@melloware/coloris/dist/coloris.min.css";
```

Do the same in `CrowdSourcingProjectColors.vue` if it imports colorpicker CSS in its `<style>` block.

- [ ] **Step 4: Build, verify, commit**

Run: `npm run build` — expected exit 0.
Verify in browser: backoffice project edit → colors section, and questionnaire statistics colors page. Picking a color updates the value as before.

```bash
git add -A && git commit -m "refactor: replace bootstrap-colorpicker with Coloris"
```

---

### Task 6: Core swap — Bootstrap 5, drop AdminLTE, new shell

This is the one atomic task. The site will not be consistent mid-task; finish all steps before building.

**Files:**
- Modify: `package.json`
- Modify: `resources/assets/sass/_variables.scss` (rewrite)
- Modify: `resources/assets/sass/common.scss`
- Modify: `resources/assets/sass/common-backoffice.scss` (rewrite)
- Create: `resources/assets/sass/backoffice/_shell.scss`
- Modify: `resources/views/backoffice/layout.blade.php` (rewrite)
- Modify: `resources/views/backoffice/partials/sidebar-menu.blade.php` (rewrite)
- Modify: `resources/views/backoffice/partials/header-controls.blade.php` (rewrite)
- Modify: `resources/assets/js/bootstrap.js`
- Modify: `resources/assets/js/common.js`
- Modify: `resources/assets/js/common-backoffice.js`
- Create: `resources/assets/js/backoffice-sidebar.js`
- Modify: `resources/assets/js/project/manage-project.js:2` (summernote bs5 build)
- Modify: `resources/assets/js/vue-components/common/TranslationsManager.vue` (summernote bs5 build)
- Modify: `resources/assets/sass/project/create-edit-project.scss:1` (summernote bs5 CSS)

**Interfaces:**
- Produces: `window.bootstrap` (the Bootstrap 5 namespace) — later tasks call `window.bootstrap.Modal`, `window.bootstrap.Tooltip`.
- Produces: `initBackofficeSidebar()` exported from `resources/assets/js/backoffice-sidebar.js`.
- Produces: body class `sidebar-collapsed`, localStorage key `backoffice.sidebar-collapsed`.
- Produces: shell CSS classes `bo-topbar`, `bo-body`, `bo-sidebar`, `bo-main`, `bo-footer` used by the three Blade files.

- [ ] **Step 1: Swap packages**

```bash
npm uninstall admin-lte datatables.net-bs4 datatables.net-buttons-bs4 datatables.net-responsive-bs4 datatables.net-select-bs4
npm install bootstrap@^5.3.8 datatables.net-bs5 datatables.net-buttons-bs5 datatables.net-responsive-bs5 datatables.net-select-bs5 datatables.net-buttons@^4.0.2 datatables.net-responsive@^4.0.2 datatables.net-select@^4.0.1
```

If npm reports a peer-dependency conflict, read the error and align the logic-package versions with what the `-bs5` packages declare — do not use `--force` or `--legacy-peer-deps`.

- [ ] **Step 2: Rewrite `resources/assets/sass/_variables.scss`**

Replace the whole file with (note: overrides BEFORE Bootstrap's variables, per BS5 convention):

```scss
@import "bootstrap/scss/functions";

// ---- Bootstrap overrides (must precede bootstrap/scss/variables) ----
$blue: #2b73fa;
$green: #39ba6e;
$primary: $blue;
$success: $green;

$font-family-sans-serif: "Open Sans", sans-serif;
$font-size-base: 1rem;
$line-height-base: 1.6;
$body-bg: #ffffff;
$link-hover-decoration: none;

@import "bootstrap/scss/variables";
@import "bootstrap/scss/variables-dark";
@import "bootstrap/scss/maps";
@import "bootstrap/scss/mixins";

// ---- Project palette (non-Bootstrap, referenced across our SCSS) ----
$brand-primary: $blue;
$brand-danger: $danger;
$red: $danger;
$green-light: #71c6ac;
$teal: #4dc0b5;
$cyan: #6cb2eb;
$grey: #e8e9eb;
$grey-light: #e0e0e0;
$beige: #dbbeb4;
$white: #ffffff;
$landing-page-primary: #232323;

// ---- Shell / navbar ----
$header-font-color: black;
$header-background-color: white;
$bg-color-navbar: #262626;
$color-navbar-head: #b8c7ce;
$navbar-brand-font-size: 16px;
$navbar-light-bg-color: #e6f6f1;

$button-background-color: $brand-primary;
$button-background-color-hover: #367fa9;

$html-font-size: 16px;
```

Then verify no removed variable is still referenced:

```bash
grep -rn "laravel-border-color\|panel-default-border\|panel-inner-border\|navbar-default-border\|list-group-border\|icon-font-path\|brand-warning\|brand-success\|text-color\|font-color\|display-font-sizes\|toRem" resources/assets/sass resources/assets/js --include="*.scss" --include="*.vue" | grep -v "_variables.scss"
```

For every hit: keep that variable in `_variables.scss` (re-add it) rather than editing the consumer. Expected known consumers to re-add if hit: `$brand-danger` (kept above). If `toRem`/`$display-font-sizes` are referenced, re-add them verbatim from git history (`git show master:resources/assets/sass/_variables.scss`).

- [ ] **Step 3: Update `resources/assets/sass/common.scss`**

- Delete line 3 (`@import "bootstrap/scss/functions";` — redundant duplicate).
- Everything else stays (Bootstrap import on line 2 now resolves to v5).

- [ ] **Step 4: Rewrite `resources/assets/sass/common-backoffice.scss`**

```scss
@import "_variables.scss";
@import "../../../node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css";
@import "../../../node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css";
@import "../../../node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
@import "../../../node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css";
@import "backoffice/shell";
```

- [ ] **Step 5: Create `resources/assets/sass/backoffice/_shell.scss`**

```scss
// Custom backoffice shell (replaces AdminLTE)

:root {
	--bo-sidebar-width: 250px;
	--bo-sidebar-width-collapsed: 4.5rem;
	--bo-topbar-height: 57px;
}

body.backoffice {
	background-color: $body-bg;
}

// ---- Topbar ----
.bo-topbar {
	position: sticky;
	top: 0;
	z-index: $zindex-sticky;
	min-height: var(--bo-topbar-height);
	background-color: $header-background-color;
	border-bottom: 1px solid $grey;
	padding-left: 25px;
	padding-right: 25px;
}

// ---- Body row ----
.bo-body {
	display: flex;
	align-items: stretch;
	min-height: calc(100vh - var(--bo-topbar-height));
}

// ---- Sidebar ----
.bo-sidebar {
	background-color: $bg-color-navbar;
	color: $color-navbar-head;
	width: var(--bo-sidebar-width);
	flex-shrink: 0;

	.nav {
		padding: 0.75rem 0.5rem;
	}

	.nav-header {
		color: rgba($color-navbar-head, 0.6);
		font-size: 0.78rem;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		padding: 0.5rem 0.75rem 0.25rem;
	}

	.nav-link {
		display: flex;
		align-items: center;
		gap: 0.65rem;
		color: $color-navbar-head;
		border-radius: $border-radius;
		padding: 0.5rem 0.75rem;
		margin-bottom: 2px;

		p {
			margin: 0;
		}

		.nav-icon {
			width: 1.25rem;
			text-align: center;
			flex-shrink: 0;
		}

		&:hover {
			color: $white;
			background-color: rgba($white, 0.08);
		}
	}

	.nav-item.active .nav-link,
	.nav-link.active {
		color: $white;
		background-color: $primary;
	}
}

@include media-breakpoint-up(lg) {
	.bo-sidebar {
		position: sticky;
		top: var(--bo-topbar-height);
		height: calc(100vh - var(--bo-topbar-height));
		overflow-y: auto;
	}

	// Collapsed-to-icons mode (desktop only)
	body.sidebar-collapsed {
		.bo-sidebar {
			width: var(--bo-sidebar-width-collapsed);

			.nav-header {
				display: none;
			}

			.nav-link {
				justify-content: center;

				p {
					display: none;
				}
			}
		}

		#sidebar-menu-toggler i {
			transform: rotate(180deg);
		}
	}
}

@include media-breakpoint-down(lg) {
	// Offcanvas mode: BS5 offcanvas-lg handles positioning; we style the panel
	.bo-sidebar {
		width: var(--bo-sidebar-width);
	}
}

#sidebar-menu-toggler i {
	transition: transform 0.2s ease-in-out;
}

// ---- Main content ----
.bo-main {
	flex-grow: 1;
	min-width: 0;
	position: relative;
	display: flex;
	flex-direction: column;
	background-color: rgba(255, 255, 255, 0.95);

	// Keep the current watermark background
	&::after {
		background-color: $body-bg;
		background-image: url(../images/active_participation.webp);
		background-size: cover;
		filter: grayscale(100%);
		opacity: 0.08;
		position: absolute;
		z-index: -1;
		content: "";
		inset: 0;
	}

	> .content {
		flex-grow: 1;
	}

	.content-header {
		padding-top: 25px;
		padding-bottom: 10px;
	}
}

#main-content {
	max-width: 1440px;
}

// ---- Footer ----
.bo-footer {
	font-size: 12px;
	padding: 0.75rem 25px;
	border-top: 1px solid $grey;
	background-color: $white;
}

// ---- Cards: modern-refresh polish ----
body.backoffice .card {
	border: 1px solid $grey;
	border-radius: $border-radius-lg;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);

	> .card-header {
		background-color: transparent;
		border-bottom: 1px solid $grey;
	}
}

.card-collapse-toggle {
	color: $secondary;
	line-height: 1;

	i {
		transition: transform 0.2s ease-in-out;
	}

	&[aria-expanded="false"] i {
		transform: rotate(180deg);
	}
}
```

- [ ] **Step 6: Rewrite `resources/views/backoffice/layout.blade.php`**

Keep the entire `<head>` as-is EXCEPT: delete the IE conditional block (`<!--[if lt IE 9]> ... <![endif]-->`). Replace `<body>`…`</body>` content with:

```blade
<body class="backoffice logged-in-env {{ !app(Gate::class)->check("moderate-content-by-users") ? "no-sidebar" : "" }} @yield('body_class')">
<div id="app">
    @include("backoffice.partials.header-controls")
    <div class="bo-body">
        @canany(['moderate-content-by-users'])
            @include("backoffice.partials.sidebar-menu")
        @endcanany
        <main class="bo-main">
            <section class="content">
                <div class="container" id="main-content">
                    <div class="content-header">
                        <div class="row my-4">
                            <div class="col p-0">
                                @yield("content-header")
                            </div>
                        </div>
                    </div>
                    @include('partials.flash-messages-and-errors')
                    @yield('content')
                </div>
            </section>
            <footer class="bo-footer">
                <div class="float-end d-none d-sm-inline">
                    <b>Version</b> {{ config("app.version") }}
                </div>
                <strong>Created by <a target="_blank" href="https://www.scify.org">SciFY.org</a></strong>
            </footer>
        </main>
    </div>
</div>

@stack("modals")
@include("partials.footer-scripts", ["includeBackofficeCommonJs" => true])

</body>
```

- [ ] **Step 7: Rewrite `resources/views/backoffice/partials/sidebar-menu.blade.php`**

Replace the wrapper (`<aside>` through `<ul ...>` and closing tags) with; the `<li>` menu items stay byte-identical to today:

```blade
<aside class="bo-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="backofficeSidebar"
       aria-label="{{ __('menu.projects') }}">
    <div class="offcanvas-header d-lg-none">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                data-bs-target="#backofficeSidebar" aria-label="Close"></button>
    </div>
    <nav class="offcanvas-body d-lg-block p-0">
        <ul class="nav flex-column" role="menu">
            {{-- existing <li> items unchanged --}}
        </ul>
    </nav>
</aside>
```

- [ ] **Step 8: Rewrite `resources/views/backoffice/partials/header-controls.blade.php`**

```blade
<nav class="bo-topbar navbar navbar-expand-lg">

    @canany(['moderate-content-by-users'])
        {{-- Desktop: collapse-to-icons toggle --}}
        <a id="sidebar-menu-toggler" class="nav-link p-0 d-none d-lg-inline-block me-3" href="#"
           role="button" aria-label="Toggle sidebar"><i class="fa fa-chevron-left"></i></a>
        {{-- Mobile: offcanvas toggle --}}
        <button class="btn d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#backofficeSidebar" aria-controls="backofficeSidebar"
                aria-label="Open menu"><i class="fa fa-bars"></i></button>
    @endcanany

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}"> {{ __('menu.home') }} </a>
            </li>
            <li class="nav-item {{ UrlMatchesMenuItem('my-dashboard') }}">
                <a class="nav-link" href="{{ route('my-dashboard') }}"> {{ __('menu.my_dashboard') }} </a>
            </li>
            <li class="nav-item {{ UrlMatchesMenuItem('my-contributions') }}">
                <a class="nav-link"
                   href="{{ route('my-contributions') }}"> {{ __('my-contributions.my_contributions') }} </a>
            </li>
            @include('partials.user-actions-header-dropdown')
            @include('partials.language-selector')
        </ul>
    </div>
</nav>
```

- [ ] **Step 9: Update `resources/assets/js/bootstrap.js`**

Replace `import "bootstrap";` and the Popper block (lines 14-16) with:

```js
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;
```

(Bootstrap 5 bundles its own Popper usage via `@popperjs/core`; `window.Popper` is no longer needed.) Verify nothing else references `window.Popper`:

```bash
grep -rn "window.Popper\|Popper\." resources/assets --include="*.js" --include="*.vue" | grep -v node_modules
```

Expected: no hits outside `bootstrap.js`. If there are hits, keep the Popper global and report.

- [ ] **Step 10: Update `resources/assets/js/common.js`**

- Delete the line `$(".dropdown-toggle").dropdown();` (Bootstrap 5's data API handles dropdowns automatically — Blade markup gets `data-bs-toggle="dropdown"` in Task 8).
- Everything else stays (jQuery, `$.ajaxSetup`, logout, smooth scroll, textarea trim).

- [ ] **Step 11: Create `resources/assets/js/backoffice-sidebar.js`**

```js
const COLLAPSED_KEY = "backoffice.sidebar-collapsed";

export function initBackofficeSidebar() {
	const body = document.body;

	try {
		if (localStorage.getItem(COLLAPSED_KEY) === "1") {
			body.classList.add("sidebar-collapsed");
		}
	} catch {
		// localStorage unavailable (private mode); ignore
	}

	const toggler = document.getElementById("sidebar-menu-toggler");
	if (!toggler) {
		return;
	}

	toggler.addEventListener("click", (e) => {
		e.preventDefault();
		const collapsed = body.classList.toggle("sidebar-collapsed");
		try {
			localStorage.setItem(COLLAPSED_KEY, collapsed ? "1" : "0");
		} catch {
			// ignore
		}
	});
}
```

- [ ] **Step 12: Rewrite `resources/assets/js/common-backoffice.js`**

```js
import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-buttons";
import "datatables.net-buttons-bs5";

import "datatables.net-responsive";
import "datatables.net-responsive-bs5";
import "datatables.net-select";
import "datatables.net-select-bs5";
import Clipboard from "clipboard/dist/clipboard";
import $ from "jquery";
import { showToast } from "./common-utils";
import { initBackofficeSidebar } from "./backoffice-sidebar";

(function () {
	const closeDismissibleAlerts = function () {
		setTimeout(function () {
			/* Close any flash message after some time*/
			window
				.$(".alert-dismissable, .alert-dismissible")
				.fadeTo(4000, 500)
				.slideUp(500, function () {
					window.bootstrap.Alert.getOrCreateInstance(this).close();
				});
		}, 5000);
	};

	const initClipboardElements = function () {
		const clipboard = new Clipboard(".copy-clipboard");

		clipboard.on("success", function (e) {
			showToast("Copied to clipboard!", "#28a745");
			e.clearSelection();
		});

		clipboard.on("error", function (e) {
			console.error(e);
			showToast(window.trans("common.copy_to_clipboard_error") + ": " + e.toString(), "#dc3545");
			e.clearSelection();
		});
	};

	const listenToReadMoreClicks = function () {
		const body = $("body");
		body.on("click", ".read-more", function () {
			$(this).siblings(".more-text").after('<a href="javascript:void(0);" class="read-less">Read less</a>');
			$(this).siblings(".more-text").removeClass("hidden");
			$(this).remove();
		});
		body.on("click", ".read-less", function () {
			$(this).siblings(".more-text").before('<a href="javascript:void(0);" class="read-more">Read more...</a>');
			$(this).siblings(".more-text").addClass("hidden");
			$(this).remove();
		});
	};

	const initializeTooltips = function () {
		document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
			window.bootstrap.Tooltip.getOrCreateInstance(el);
		});
	};

	$(document).ready(function () {
		initBackofficeSidebar();
		closeDismissibleAlerts();
		initClipboardElements();
		listenToReadMoreClicks();
		initializeTooltips();
	});
})();

export function isObject(obj) {
	return obj != null && obj.constructor.name === "Object";
}
```

Note: `toggleIconOnSidebarMenuToggle` is gone — the chevron flip is CSS (`.sidebar-collapsed #sidebar-menu-toggler i`). `initializeIcheck` was removed in Task 3.

- [ ] **Step 13: Summernote bs5 build**

- `resources/assets/js/project/manage-project.js:2`: change `summernote/dist/summernote-bs4.min` → `summernote/dist/summernote-bs5.min`.
- `resources/assets/js/vue-components/common/TranslationsManager.vue`: same import swap if present (check with `grep -n "summernote" resources/assets/js/vue-components/common/TranslationsManager.vue`).
- `resources/assets/sass/project/create-edit-project.scss:1`: change `summernote-bs4.css` → `summernote-bs5.css`.

- [ ] **Step 14: Kill remaining AdminLTE references**

```bash
grep -rn "admin-lte\|adminlte\|hold-transition\|skin-white\|sidebar-mini\|layout-navbar-fixed\|content-wrapper\|main-sidebar\|nav-sidebar\|data-widget" resources/ --include="*.js" --include="*.vue" --include="*.scss" --include="*.blade.php"
```

Expected: zero hits (except possibly `content-wrapper` in unrelated public SCSS — inspect each hit; anything AdminLTE-related must be fixed).
Note: the two public navbars keep class `main-header` — that class is ours (defined in `common.scss`), not AdminLTE's, so `main-header` hits in `home/partials/navbar.blade.php` and `crowdsourcing-project/partials/navbar.blade.php` are fine.

- [ ] **Step 15: Build and smoke-test**

Run: `npm run build` — expected exit 0. Sass deprecation WARNINGS are acceptable; errors are not.
Browser: log in, open the backoffice projects index. Expected: topbar, dark sidebar, content, footer render; sidebar toggle collapses to icons and persists on reload; at 375px the sidebar becomes an offcanvas. Dropdowns will NOT work yet (markup still says `data-toggle`) — that is Task 8; ignore here.

- [ ] **Step 16: Commit**

```bash
git add -A && git commit -m "feat: replace AdminLTE with custom Bootstrap 5 backoffice shell"
```

---

### Task 7: Card collapse widgets

**Files:**
- Modify: the 2 backoffice Blade files containing `card-tools` / `data-card-widget="collapse"` (find with the grep below)

- [ ] **Step 1: Find the widgets**

```bash
grep -rln "card-tools\|data-card-widget" resources/views
```

- [ ] **Step 2: Convert each (7 occurrences)**

Before (AdminLTE):

```html
<div class="card-header">
    <h3 class="card-title">Title</h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
</div>
<div class="card-body">...</div>
```

After (Bootstrap 5 collapse; give each card body a unique id, e.g. `card-body-landing-page`):

```html
<div class="card-header d-flex align-items-center">
    <h3 class="card-title mb-0">Title</h3>
    <button type="button" class="btn btn-sm btn-link ms-auto card-collapse-toggle" data-bs-toggle="collapse"
            data-bs-target="#card-body-landing-page" aria-expanded="true" aria-controls="card-body-landing-page">
        <i class="fa fa-chevron-up"></i>
    </button>
</div>
<div class="collapse show" id="card-body-landing-page">
    <div class="card-body">...</div>
</div>
```

No JS needed: Bootstrap toggles `aria-expanded`, and `_shell.scss` rotates the chevron.

- [ ] **Step 3: Verify, build, commit**

`grep -rn "card-tools\|data-card-widget\|btn-tool" resources/views` — expected: zero hits.
Run `npm run build`; verify one converted card collapses/expands in the browser.

```bash
git add -A && git commit -m "refactor: convert AdminLTE card widgets to Bootstrap 5 collapse"
```

---### Task 8: Site-wide Blade markup migration (BS4 → BS5)

**Files:**
- Modify: all Blade files under `resources/views/` (about 30 with hits)

- [ ] **Step 1: Mechanical attribute renames (safe sed)**

```bash
cd /home/paul/projects/Crowdsourcing-Platform
grep -rl 'data-toggle=\|data-dismiss=\|data-target=' resources/views --include="*.blade.php" | \
  xargs sed -i 's/data-toggle=/data-bs-toggle=/g; s/data-dismiss=/data-bs-dismiss=/g; s/data-target=/data-bs-target=/g'
```

- [ ] **Step 2: Utility class renames (word-boundary regex, then review the diff)**

```bash
grep -rl 'class="[^"]*\b\(ml\|mr\)-' resources/views --include="*.blade.php" | \
  xargs sed -i -E 's/\bml-(auto|[0-5])\b/ms-\1/g; s/\bmr-(auto|[0-5])\b/me-\1/g'
grep -rl 'float-right\|float-left\|text-right\|text-left\|sr-only\|badge-pill' resources/views --include="*.blade.php" | \
  xargs sed -i 's/\bfloat-right\b/float-end/g; s/\bfloat-left\b/float-start/g; s/\btext-right\b/text-end/g; s/\btext-left\b/text-start/g; s/\bsr-only\b/visually-hidden/g; s/\bbadge-pill\b/rounded-pill/g'
```

Then run `git diff --stat` and eyeball `git diff` — revert any hit inside a non-Bootstrap context (e.g. a CSS class the project defines itself; check `text-right`-style names against `resources/assets/sass`).

- [ ] **Step 3: Close buttons (12 occurrences, manual)**

`grep -rn 'class="close"' resources/views` — for each:

Before: `<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>`
After: `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`

(Remove the inner `<span>&times;</span>` — `btn-close` draws its own icon.)

- [ ] **Step 4: Form groups (82 occurrences, semi-manual)**

`grep -rn "form-group" resources/views` — for each: replace `form-group` with `mb-3`, and add `form-label` to the `<label>` inside that group. Example:

Before:

```html
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name">
</div>
```

After:

```html
<div class="mb-3">
    <label class="form-label" for="name">Name</label>
    <input type="text" class="form-control" id="name">
</div>
```

Where the group is `form-group row` (horizontal form), use `row mb-3` and give the label `col-form-label` (keep any existing `col-*` classes).

- [ ] **Step 5: Input groups (9 occurrences, backoffice)**

`grep -rn "input-group" resources/views` — Bootstrap 5 removed `input-group-append`/`prepend` wrappers (survey says none exist here, so most groups need no change). Verify each renders: buttons/spans inside `input-group` must be direct children with class `input-group-text` for text addons.

- [ ] **Step 6: Verify zero leftovers, build, commit**

```bash
grep -rn 'data-toggle=\|data-dismiss=\|data-target=\|class="close"\|form-group\|\bml-[0-5aut]\|\bmr-[0-5aut]' resources/views --include="*.blade.php"
```

Expected: zero hits. Run `npm run build` (exit 0). In the browser: user dropdown opens, language selector opens, a modal opens and closes, flash message auto-dismisses.

```bash
git add -A && git commit -m "refactor: migrate Blade markup from Bootstrap 4 to Bootstrap 5"
```

---

### Task 9: Vue SFC markup + Bootstrap JS API conversions

**Files:**
- Modify: all 16 SFCs under `resources/assets/js/vue-components/` with BS4 markup
- Modify: `resources/assets/js/questionnaire/questionnaire-reports.js` (modal calls)
- Modify: `resources/assets/js/vue-components/common/TranslationsManager.vue` (modal call)
- Modify: any other file calling jQuery Bootstrap plugin methods

**Interfaces:**
- Consumes: `window.bootstrap` from Task 6.

- [ ] **Step 1: Markup renames in Vue files**

Apply the same sed set as Task 8 Steps 1-2 but for `resources/assets/js/vue-components --include="*.vue"`. Then handle `form-group` (13), `class="close"`, and `badge badge-secondary` → `badge text-bg-secondary` (2) manually with the same patterns as Task 8.

- [ ] **Step 2: Convert jQuery Bootstrap plugin calls**

Find them:

```bash
grep -rn '\.modal(\|\.tooltip(\|\.popover(\|\.collapse(\|\.dropdown(\|\.alert(' resources/assets/js --include="*.js" --include="*.vue"
```

Conversion pattern:

```js
// Before
window.$("#previewModal").modal("show");
window.$("#previewModal").modal("hide");

// After
window.bootstrap.Modal.getOrCreateInstance(document.getElementById("previewModal")).show();
window.bootstrap.Modal.getOrCreateInstance(document.getElementById("previewModal")).hide();
```

For modal events: `$("#m").on("hidden.bs.modal", fn)` → `document.getElementById("m").addEventListener("hidden.bs.modal", fn)`.

- [ ] **Step 3: Verify, build, lint, commit**

Re-run the grep from Step 2 — expected: zero jQuery plugin calls remain. Run `npm run build` and `npm run lint` — both exit 0 (fix any lint fallout from edited files only).
Browser: TranslationsManager preview modal opens; questionnaire reports page modal opens; ProblemsManagement/SolutionsManagement tables render.

```bash
git add -A && git commit -m "refactor: migrate Vue components and JS to Bootstrap 5 APIs"
```

---

### Task 10: select2 restyle, xxl shim removal, CSS sweep

**Files:**
- Modify: `resources/assets/sass/shared/select2-custom.scss`
- Delete: `resources/assets/sass/problem/bootstrap_4point6_custom_xxl.scss`
- Modify: `resources/assets/sass/problem/landing-page.scss`, `resources/assets/sass/problem/show-page.scss`, `resources/assets/sass/solution/propose-page.scss` (remove the shim import)
- Modify: any SCSS with BS4-only class references

- [ ] **Step 1: Remove the xxl shim**

Delete `resources/assets/sass/problem/bootstrap_4point6_custom_xxl.scss` and its `@import` line in the three consumer files. Verify: `grep -rn "bootstrap_4point6" resources/` — zero hits.

- [ ] **Step 2: Restyle select2 for BS5**

In `resources/assets/sass/shared/select2-custom.scss`, align the select2 control with BS5 form-controls (heights and focus ring). Append:

```scss
.select2-container--default .select2-selection--single,
.select2-container--default .select2-selection--multiple {
	border: 1px solid $border-color;
	border-radius: $border-radius;
	min-height: calc(1.5em + 0.75rem + 2px);
}

.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--multiple {
	border-color: tint-color($primary, 50%);
	box-shadow: 0 0 0 0.25rem rgba($primary, 0.25);
	outline: 0;
}
```

Adjust existing rules in the file that fight these (read the file first).

- [ ] **Step 3: Sweep SCSS for BS4-only selectors**

```bash
grep -rn "input-group-addon\|\.close\b\|badge-pill\|custom-control\|form-group\|sr-only" resources/assets/sass
```

Fix each hit: `.input-group-addon` → `.input-group-text` (the `.color-picker` rule in `common.scss` ~line 307 — align with the Coloris markup from Task 5), `form-group` → `mb-3` context, `sr-only` → `visually-hidden`.

- [ ] **Step 4: Build, verify, commit**

`npm run build` — exit 0. Browser: project edit keywords select2 field renders and focuses correctly; problem landing page layout unchanged at 1600px width (xxl behavior now native).

```bash
git add -A && git commit -m "refactor: BS5 select2 restyle, remove BS4 xxl shim, CSS sweep"
```

---

### Task 11: Full verification

Performed by the MAIN session (needs browser tools).

- [ ] **Step 1: Automated checks**

```bash
npm run build && npm run lint && composer lint
php artisan test
```

Expected: all pass. PHPUnit failures unrelated to views must be reported, not "fixed".

- [ ] **Step 2: After-screenshots and comparison**

Capture the same pages as Task 1 (named `after-<slug>.png`) at the same widths. Compare each before/after pair side by side. Differences must be: intentional refresh polish (spacing, borders, shadows, focus states) only. Layout breaks, missing widgets, unstyled controls = defects to fix.

- [ ] **Step 3: Manual QA checklist (in browser, as admin)**

- Sidebar: toggle collapse, reload persists, offcanvas at 375px opens/closes
- Topbar: user dropdown, language selector, Home/Dashboard/Contributions links
- Flash message appears and auto-dismisses after ~9s
- DataTables pages: manage users (search + pagination), questionnaires, responses/reports (open a response modal, delete flow shows sweetalert2), my-contributions, problems, solutions
- Project create/edit: summernote editors load and format text; select2 keywords; color pickers; card collapse chevrons; icheck-replaced checkboxes
- Questionnaire create/edit: SurveyJS creator loads; save flows; sweetalert2 dialogs
- Public: home, project landing page, questionnaire fill-in (SurveyJS renders, submit works), problem page at mobile + xxl widths, login page
- Tooltips render on hover where `data-bs-toggle="tooltip"` exists

- [ ] **Step 4: Fix defects, re-verify, final commit**

Each defect: fix, `npm run build`, re-check the page. Then:

```bash
git add -A && git commit -m "fix: post-migration visual and behavior fixes"
```

- [ ] **Step 5: Report**

Summarize: what changed, screenshot pairs worth the user's review, any known visual deltas, and remaining risks.
