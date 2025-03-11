# Playwright Test Module Manual

## Introduction
This manual will guide you through the process of testing the Playwright module in the repository.

## Prerequisites
- Node.js installed
- npm (Node Package Manager) installed
- Playwright installed

## Installation
1. Clone the repository:
    ```sh
    git clone <repository-url>
    ```
2. Navigate to the project directory:
    ```sh
    cd git-group-repository-group-5-sec-2/Test/playwright_test
    ```
3. Install the dependencies:
    ```sh
    npm install
    ```

## Running Tests
1. To run all tests, use the following command:
    ```sh
    npx playwright test
    ```
2. To run a specific test file:
    ```sh
    npx playwright test <test-file-name>
    ```
3. To run tests with a specific browser (e.g., Chromium, Firefox, WebKit):
    ```sh
    npx playwright test --project=<browser-name>
    ```

## Viewing Test Results
- After running the tests, a summary will be displayed in the terminal.
- To view detailed results, open the Playwright Test Report:
    ```sh
    npx playwright show-report
    ```

## Writing New Tests
1. Create a new test file in the `tests` directory with a `.spec.ts` extension.
2. Use the following template to write your test:
    ```typescript
    import { test, expect } from '@playwright/test';

    test('example test', async ({ page }) => {
        await page.goto('https://example.com');
        const title = await page.title();
        expect(title).toBe('Example Domain');
    });
    ```

## Additional Resources
- [Playwright Documentation](https://playwright.dev/docs/intro)
- [Playwright GitHub Repository](https://github.com/microsoft/playwright)

## Support
For any issues or questions, please contact the project maintainers.
