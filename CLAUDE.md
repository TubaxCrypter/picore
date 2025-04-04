# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Build/Test Commands
- Run dev server: `composer run dev` (starts server, queue, vite)
- Build: `npm run build`
- Run tests: `./vendor/bin/pest`
- Run single test: `./vendor/bin/pest tests/Path/To/TestFile.php`
- PHP linting: `./vendor/bin/pint`

## Code Style Guidelines
- PHP: PSR-4 autoloading, Laravel conventions (PHP 8.2+)
- Controllers: RESTful, thin controllers with business logic in services
- Models: Follow Laravel Eloquent patterns
- Frontend: Vue 3 with Inertia.js and TailwindCSS
- Naming: CamelCase for classes, snake_case for methods/variables
- Error handling: Use Laravel exception handling and form validation
- TypeScript: Prefer explicit types when not obvious from context
- Imports: Group by category (framework, vendor, project)
- Security: Always validate/sanitize inputs, use Laravel's CSRF protection