# Backoffice Redesign: Drop AdminLTE, Migrate to Bootstrap 5

Date: 2026-09-01
Status: Approved design, pending implementation plan

## 1. Goal

Remove the `admin-lte` dependency and rebuild the backoffice shell as a small custom
Bootstrap 5 layout. Migrate the whole site (public and backoffice) from Bootstrap 4 to
Bootstrap 5 in the same effort. Apply a "modern refresh": keep the layout structure that
admins know (fixed top navbar, dark sidebar, cards), keep the brand identity (Open Sans,
`#2b73fa` primary, `#262626` sidebar), and modernize spacing, borders, shadows, and
focus states.

## 2. Non-goals

- No jQuery removal. jQuery stays. Only plugins that Bootstrap 5 breaks are replaced.
- No DataTables replacement. Only its styling packages change from `-bs4` to `-bs5`.
- No SurveyJS migration. `survey-jquery` and `survey-creator` stay as they are.
- No Font Awesome upgrade. FA 5 stays; the FA 7 bump is a separate later PR.
- No jQuery 4 upgrade. jQuery stays at 3.7.x; the 4.x bump is a separate later PR.
- No redesign of public-facing pages. Public pages receive only the mechanical
  Bootstrap 5 markup migration; their visual design does not change.
- No new backoffice features or navigation changes.

## 3. Decisions already made

| Decision | Choice |
|---|---|
| Shell strategy | Hand-rolled SCSS on Bootstrap 5 primitives; no admin framework |
| Visual goal | Modern refresh; keep structure and brand, not pixel-bound to AdminLTE 3 |
| Scope | Whole site moves to Bootstrap 5 in one effort |
| Plugin scope | Replace only what Bootstrap 5 breaks |
| Baseline | Screenshot all backoffice pages on the running local instance before work starts |

## 4. Current state (surveyed)

- `admin-lte@3.2.0` is imported in exactly two places:
  `resources/assets/js/common-backoffice.js:4` and
  `resources/assets/sass/common-backoffice.scss:2`.
- AdminLTE markup lives in `resources/views/backoffice/layout.blade.php`,
  `backoffice/partials/sidebar-menu.blade.php`,
  `backoffice/partials/header-controls.blade.php`, and 7 `card-tools` /
  `data-card-widget="collapse"` uses across 2 backoffice files.
- The sidebar menu is flat. No item has a submenu, so no treeview logic is needed.
- Two public navbars reuse the `.main-header` class:
  `resources/views/crowdsourcing-project/partials/navbar.blade.php` and
  `resources/views/home/partials/navbar.blade.php`.
- Bootstrap 4 markup counts in Blade: `data-toggle=` 29, `data-dismiss=` 18,
  `data-target=` 9, `form-group` 82, `class="close"` 12, `ml-/mr-` 24,
  `input-group` 9. Vue SFCs add: `data-dismiss=` 10, `form-group` 13,
  `data-toggle=` 5, `input-group` 5, `ml-/mr-` 24.
- `resources/assets/sass/problem/bootstrap_4point6_custom_xxl.scss` is a hand-rolled
  `xxl` breakpoint shim for BS 4.6, imported by `problem/landing-page.scss`,
  `problem/show-page.scss`, `solution/propose-page.scss`.
- Dead packages: `fastclick` and `jquery-slimscroll` are imported but never called;
  `jquery-sparkline` is fully unused.

## 5. Layout architecture

### 5.1 `backoffice/layout.blade.php` (rewrite)

- Remove AdminLTE body classes (`hold-transition`, `skin-white`, `sidebar-mini`,
  `layout-fixed`, `layout-navbar-fixed`) and the `.wrapper`/`.content-wrapper`
  AdminLTE structure.
- New structure: fixed top navbar; below it a flex row with the sidebar column and a
  scrollable content column; footer at the bottom of the content column.
- Keep the `no-sidebar` case: users without the `moderate-content-by-users` gate get
  no sidebar and a full-width content column, as today.
- Keep `@yield` sections, `@stack('css')`, `@stack('modals')`, flash messages, and the
  footer content unchanged.
- Remove the IE8 conditional scripts (`html5shiv`, `respond.js`).

### 5.2 Sidebar (`backoffice/partials/sidebar-menu.blade.php`, rewrite markup only)

- Same menu items, same `@can` gates, same `UrlMatchesMenuItem()` active-state helper.
- On `lg` and up: static fixed column, dark background (`#262626` family), with a
  collapse-to-icons toggle. Collapsed state persists in `localStorage`.
- Below `lg`: the same partial renders inside a Bootstrap 5 offcanvas, opened by the
  navbar toggle button.

### 5.3 Header (`backoffice/partials/header-controls.blade.php`, rewrite markup only)

- Same content: sidebar toggle, Home / My dashboard / My contributions links, user
  dropdown, language selector.
- Bootstrap 5 navbar markup: `data-bs-toggle`, `ms-auto` instead of `ml-auto`;
  dropdowns use Bootstrap 5's vanilla dropdown behavior.
- The sidebar toggle button (`#sidebar-menu-toggler`) drives the new sidebar module
  instead of AdminLTE's `data-widget="pushmenu"`.

### 5.4 Card collapse widgets

- The 7 `card-tools` / `btn-tool` / `data-card-widget="collapse"` uses map to
  Bootstrap 5 `collapse` on the card body, with a chevron button in the card header.
- One shared helper (about 10 lines) initializes the chevron rotation.

### 5.5 Public `.main-header` navbars

- Define `.main-header` in our own SCSS so the two public navbars keep their current
  look without AdminLTE.

## 6. SCSS architecture

- `resources/assets/sass/common-backoffice.scss`: remove
  `admin-lte/build/scss/adminlte.raw`; add `backoffice/_shell.scss`; switch the four
  DataTables CSS imports to the `-bs5` packages.
- New `resources/assets/sass/backoffice/_shell.scss`: sidebar, topbar, content
  spacing, footer, card polish. Target size: about 250 lines. Use Bootstrap 5
  variables and CSS custom properties so brand colors flow in.
- `resources/assets/sass/_variables.scss`: rewrite for Bootstrap 5. Keep the brand
  values (`#2b73fa`, `#262626`, Open Sans, `$theme-colors` map). Remove dead BS3-era
  variables (`$icon-font-path`, `$panel-*`, `$brand-*`, `$navbar-default-border`).
  Resolve the duplicate `$body-bg` and `$green` definitions.
- `resources/assets/sass/common.scss`: `bootstrap/scss/bootstrap` now resolves to
  Bootstrap 5. Remove the icheck skin import. Update the sweetalert import to
  sweetalert2's CSS.
- Delete `resources/assets/sass/problem/bootstrap_4point6_custom_xxl.scss` and its
  three imports. Bootstrap 5 ships the `xxl` breakpoint natively.
- `resources/assets/sass/questionnaire/statistics.scss`: keep the plain DataTables
  CSS import as-is (it does not depend on Bootstrap).
- `resources/assets/sass/shared/select2-custom.scss`: restyle select2 to match
  Bootstrap 5 form controls.

## 7. Markup migration (site-wide, mechanical)

Apply across about 20 backoffice Blades, about 10 public Blades, and 16 Vue SFCs:

| Bootstrap 4 | Bootstrap 5 |
|---|---|
| `data-toggle=` / `data-dismiss=` / `data-target=` | `data-bs-toggle=` / `data-bs-dismiss=` / `data-bs-target=` |
| `class="close"` + `&times;` | `class="btn-close"` (no inner content) |
| `form-group` | `mb-3`; labels get `form-label` |
| `ml-*` / `mr-*` | `ms-*` / `me-*` |
| `float-right` / `float-left` | `float-end` / `float-start` |
| `text-right` / `text-left` | `text-end` / `text-start` |
| `input-group` structure | Bootstrap 5 flat `input-group` children |
| `sr-only` | `visually-hidden` |
| `badge badge-secondary` (2 Vue uses) | `badge text-bg-secondary` |

The domain-specific `badge-single` / `badge-title` gamification classes are not
Bootstrap classes and do not change.

## 8. JavaScript changes

Bootstrap 5 removed its jQuery plugin API, so these call sites convert to the vanilla
`bootstrap.*` API even though jQuery itself stays:

- `$(...).modal(...)` calls in `resources/assets/js/questionnaire/questionnaire-reports.js`,
  `resources/assets/js/vue-components/common/TranslationsManager.vue`, and page scripts
  → `bootstrap.Modal.getOrCreateInstance(...)`.
- `.tooltip()`, `.dropdown()`, `.alert("close")` in `common.js` / `common-backoffice.js`
  → `bootstrap.Tooltip`, native dropdown data API, `bootstrap.Alert`.
- `resources/assets/js/bootstrap.js`: import `bootstrap` (v5) and expose
  `window.bootstrap`; keep jQuery exposure as-is.
- `resources/assets/js/common-backoffice.js`: remove the `admin-lte`, `fastclick`,
  `jquery-slimscroll`, and `icheck` imports; add a sidebar module (about 40 lines,
  vanilla JS): toggle, `localStorage` persistence, offcanvas wiring.

Forced plugin swaps:

- `icheck` → native Bootstrap 5 `form-check` markup in `auth/login.blade.php` and the
  two project create-edit partials; delete the package.
- `bootstrap-sweetalert` → `sweetalert2` in `questionnaire-reports.js`,
  `QuestionnaireDisplay.vue`, `QuestionnaireCreateEdit.vue` (about 7 call sites);
  delete the package.
- `bootstrap-colorpicker` → Coloris in `questionnaire-statistics-colors.js` and
  `CrowdSourcingProjectColors.vue`; delete the package and its SCSS.
- `summernote`: switch imports from `summernote-bs4` to `summernote-bs5` in
  `project/manage-project.js`, `TranslationsManager.vue`, and
  `create-edit-project.scss`.
- `select2`: keep the package; restyle via `select2-custom.scss`.

## 9. package.json changes

Remove: `admin-lte`, `fastclick`, `jquery-slimscroll`, `jquery-sparkline`, `icheck`,
`bootstrap-sweetalert`, `bootstrap-colorpicker`, `datatables.net-bs4`,
`datatables.net-buttons-bs4`, `datatables.net-responsive-bs4`,
`datatables.net-select-bs4`.

Add: `sweetalert2`, `@melloware/coloris`, `datatables.net-bs5`,
`datatables.net-buttons-bs5`, `datatables.net-responsive-bs5`,
`datatables.net-select-bs5`.

Change: `bootstrap` `^4.6.2` → `^5.3.8`.

Unchanged in this effort: `jquery`, `@fortawesome/fontawesome-free`, `datatables.net`
core and `-buttons`/`-responsive`/`-select` logic packages, `select2`,
`jquery-toast-plugin`, all SurveyJS packages, `cross-env`, `eslint`.

## 10. Verification

1. Baseline: log in at `http://127.0.0.1:8000/en` as `platform-admin@crowd.com`
   (password from `DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED` in `.env`). Screenshot every
   backoffice page and the key public pages before any change.
2. After migration: capture the same pages and compare side by side.
3. `npm run build` completes without errors or SCSS deprecation failures.
4. `composer lint` passes (Pint + ESLint).
5. The PHPUnit suite passes unchanged.
6. Manual QA checklist: sidebar toggle and persistence, offcanvas on mobile width,
   all modals, DataTables pages (manage users, questionnaires, reports, contributions,
   problems, solutions), summernote editors, color pickers, sweetalert flows in
   questionnaire create/edit/display, select2 fields, language selector, user
   dropdown, flash messages, login page checkbox, public questionnaire flow.

## 11. Risks

- Bootstrap 5 changes default form/typography rendering site-wide; public pages need
  the visual comparison pass too, not only the backoffice.
- SurveyJS renders its own DOM with its own CSS; verify the questionnaire display and
  statistics pages against the baseline since surrounding CSS changes.
- Coloris has a different API shape than bootstrap-colorpicker; the two color-picker
  files need real retesting, not just compile checks.
- `select2` default theme against BS5 can look off; the restyle must cover focus and
  sizing states.
