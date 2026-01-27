# Contributing Guide

Thank you for contributing to the **OJT DTR & Weekly Journal System**. This document outlines how team members collaborate, contribute code, and maintain project stability.

This project follows a **feature-based ownership model** and a **fork + pull request workflow**.

---

## 1. Tech Stack

All contributions must align with the approved stack:

* Laravel (Backend Framework)
* FilamentPHP (Admin & Panel UI)
* Tailwind CSS (Styling)
* PestPHP (Testing)

---

## 2. Repository Workflow

### Fork-Based Development

1. Fork the main repository
2. Clone your fork locally
3. Create a feature branch from `main`
4. Develop your assigned feature
5. Push changes to your fork
6. Open a Pull Request (PR) to the main repository

Direct commits to `main` are not allowed.

---

## 3. Branching Convention

Use clear and descriptive branch names:

* `feature/dtr`
* `feature/weekly-reports`
* `feature/admin-review`
* `feature/exports`

Each branch should focus on **one feature only**.

---

## 4. Feature Ownership

Each developer owns their assigned feature end-to-end, including:

* Database structure related to the feature
* Backend logic and validation
* Filament UI components
* Basic automated tests

Developers may extend shared structures but should avoid breaking existing contracts.

---

## 5. Shared Contracts

Certain elements are treated as shared system contracts:

* Core table names
* Primary relationships
* Common status values

Changes to shared contracts must be coordinated before implementation.

---

## 6. Pull Request Guidelines

Before opening a PR, ensure that:

* The PR addresses a single feature or concern
* The code follows existing conventions
* The feature works independently
* Basic PestPHP tests are included where applicable
* No unrelated files are modified

PRs may receive feedback or requests for changes before approval.

---

## 7. Testing Expectations

* PestPHP is used for testing
* Tests should validate core behavior and common edge cases
* Full coverage is not required, but intentional testing is expected

---

## 8. Dummy Data & Seeders

Developers are allowed to:

* Use seeders
* Mock or assume the existence of shared data

This enables parallel development and reduces feature dependency.

---

## 9. Definition of Done

A feature is considered **done** when:

* Core functionality is complete
* Shared contracts are respected
* Existing features are not broken
* Tests pass
* The PR is reviewed and approved

---

## 10. Code Review & Merging

* All PRs are reviewed before merging
* The Project Manager is responsible for approving and merging PRs
* Merge conflicts should be resolved before approval

---

## 11. Communication

When in doubt:

* Ask questions early
* Communicate changes that may affect other features
* Avoid assumptions about shared logic

Collaboration and clarity are key to project success.
