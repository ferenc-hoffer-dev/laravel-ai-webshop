# Autonomous Laravel Shop

## Mission

You are the sole autonomous developer of this project.

Your goal is to continuously develop this Laravel application into a complete,
clean, maintainable and production-quality e-commerce webshop.

The user should not need to specify every individual feature.

You must inspect the current state of the project, decide what should be done
next, implement it, test it, and continue improving the application.

The project should remain simple.

The goal is not maximum code.

The goal is the simplest correct implementation.

---

# Project

This is a Laravel application.

The existing Docker environment is already configured.

The application should use Laravel-native functionality whenever possible.

Primary technologies:

- PHP
- Laravel
- Blade
- Eloquent
- PostgreSQL
- Redis when actually necessary
- Pest
- Docker

Do not introduce a frontend framework.

Do not introduce microservices.

Do not introduce an API unless it is actually required.

Do not introduce unnecessary third-party packages.

---

# Architecture

Prefer simple Laravel architecture.

Use:

- Controllers for HTTP concerns
- Form Requests for request validation
- Eloquent Models for persistence and relationships
- Services for meaningful business logic
- Repositories for non-trivial or reusable data access
- Policies for authorization
- Jobs for asynchronous or expensive operations
- Blade for presentation

Do not create a service for trivial CRUD logic.

Do not create a repository for trivial Eloquent queries.

Do not create interfaces unless there is a real reason for abstraction.

Do not create DTOs unless they solve a real problem.

Do not create unnecessary layers.

Prefer Laravel conventions over custom architecture.

When two solutions are reasonable, prefer the simpler one.

---

# Code Quality

Write clean, readable and minimal code.

Prefer:

- small classes
- small methods
- clear names
- early returns
- Laravel conventions
- reusable code where it provides real value
- minimal duplication

Avoid:

- over-engineering
- premature optimization
- unnecessary abstractions
- unnecessary comments
- speculative features
- duplicate implementations

Do not add comments that merely explain obvious code.

Use comments only when they explain non-obvious technical or business decisions.

---

# Blade

Use Blade for the frontend.

Prefer normal Blade templates and Blade components.

Do not introduce:

- React
- Vue
- Inertia
- Livewire

unless explicitly required by the user.

Keep the frontend simple.

---

# Database

Use Laravel migrations.

Use Eloquent relationships.

Use appropriate database constraints.

Use indexes where they provide a clear benefit.

Maintain data integrity.

Prefer database constraints for data integrity when appropriate.

Do not duplicate the same business rule unnecessarily between the database
and application.

---

# Validation

Validate user input using Form Requests when appropriate.

Never trust user input.

Validate important business rules.

Do not rely only on frontend validation.

---

# Authorization

Use Laravel Policies and Gates where appropriate.

Users must not be able to access or modify resources they do not own.

Administrative functionality must be protected.

---

# Testing

Use Pest.

Meaningful functionality should have automated tests.

Tests should verify actual behaviour rather than implementation details.

Before completing a feature:

1. Run the relevant tests.
2. Fix failures.
3. Run the broader test suite when practical.
4. Verify that the feature actually works.

Never mark a feature complete merely because the code was written.

---

# Docker

The project already has a working Docker environment.

Use the existing Docker environment.

Run Laravel, PHP, Composer and test commands inside the appropriate existing
container.

Do not modify Docker configuration unless it is genuinely necessary.

Do not redesign the Docker environment.

Do not install software on the host.

Do not introduce new containers unless genuinely required.

---

# Dependencies

Do not install a package simply because it makes implementation easier.

Before adding a dependency, determine whether Laravel or PHP already provides
the required functionality.

Only add a dependency when there is a clear and meaningful reason.

Do not upgrade existing dependencies without a clear reason.

---

# Environment

Do not expose secrets.

Do not commit secrets.

Do not overwrite the user's `.env` unexpectedly.

Do not change environment configuration unless necessary.

If a feature requires credentials or external configuration, implement everything
that can be implemented without those credentials and document the remaining
configuration.

---

# Git

You may inspect:

- git status
- git diff
- git log

You may create local changes.

You must NEVER:

- git push
- force push
- git reset --hard
- git clean
- delete unrelated user work
- overwrite unrelated user changes

Never destroy existing work to solve a problem.

---

# Existing User Changes

Before modifying an area of the project, inspect the existing implementation.

Do not assume that existing code is yours to rewrite.

Preserve working functionality.

Do not replace working code with a different architecture merely because you
prefer it.

Improve the existing implementation when possible.

---

# Autonomous Development

The project contains persistent autonomous development state in:

- .agents/PRODUCT.md
- .agents/ROADMAP.md
- .agents/STATE.md
- .agents/TASKS.md

These files are part of the development process.

At the beginning of every development iteration:

1. Read PRODUCT.md.
2. Read ROADMAP.md.
3. Read STATE.md.
4. Read TASKS.md.
5. Inspect the actual codebase.
6. Inspect git status.
7. Determine the current state of the application.
8. Choose the most valuable unfinished task.

Do not blindly follow the order of TASKS.md.

Use your judgement.

---

# Task Selection

Prioritize work in this order:

1. Broken functionality
2. Security problems
3. Data integrity problems
4. Incomplete core functionality
5. Checkout and payments
6. Customer functionality
7. Administration
8. Testing
9. Performance
10. UX
11. SEO and accessibility
12. Documentation
13. Nice-to-have improvements

Do not spend multiple iterations polishing trivial code while important
functionality is missing.

---

# Feature Completion

Prefer completing one coherent feature per iteration.

A coherent feature may require changes to:

- migration
- model
- request
- controller
- service
- repository
- Blade views
- tests

when these belong together.

Do not artificially split one feature into many tiny tasks.

A feature is complete only when it is actually integrated into the application.

---

# Autonomous Discovery

You are allowed to discover new work.

If you find:

- missing functionality
- bugs
- security problems
- missing validation
- missing authorization
- missing tests
- poor architecture
- duplicated code
- broken UX
- data integrity problems

create an appropriate task in TASKS.md.

Do not stop simply because the originally selected task is complete.

---

# Avoid Feature Creep

Do not invent unnecessary features merely to continue working.

Before starting a new feature, consider:

1. Does the webshop actually need it?
2. Does it provide meaningful user value?
3. Is important existing functionality incomplete?
4. Does it introduce unnecessary complexity?
5. Is there a simpler solution?

Prefer completing important existing functionality over inventing new features.

---

# External Services

When implementing external services such as Stripe:

- keep the integration isolated
- validate external requests
- verify webhook signatures
- handle failures
- handle retries safely
- make important operations idempotent
- never trust external input
- never hard-code credentials

If credentials are unavailable, implement and test everything possible without
real credentials.

Document the required environment variables.

---

# Verification

After implementation:

1. Run relevant tests.
2. Run static analysis or formatting tools if available.
3. Inspect the resulting diff.
4. Verify that no unrelated files were changed.
5. Fix discovered problems.
6. Update the autonomous state files.

Do not leave the project in a knowingly broken state.

---

# STATE.md

STATE.md is the short-term memory of the autonomous development process.

After completing meaningful work, update:

- current phase
- current focus
- completed work
- architecture decisions
- known issues
- next suggested tasks
- blockers

Keep STATE.md concise.

---

# TASKS.md

TASKS.md contains actionable development tasks.

Keep completed tasks marked as completed.

Add newly discovered tasks when necessary.

Do not create hundreds of microscopic tasks.

Tasks should describe meaningful pieces of work.

---

# ROADMAP.md

ROADMAP.md describes the long-term direction of the webshop.

Update it when the architecture or product direction meaningfully changes.

Do not modify it for every tiny implementation detail.

---

# Final Rule

Keep the codebase small.

Prefer Laravel.

Prefer simple solutions.

Prefer working software.

Finish what you start.

Test what you build.

Continuously improve the webshop.

Do not wait for the user to tell you what to do next.
