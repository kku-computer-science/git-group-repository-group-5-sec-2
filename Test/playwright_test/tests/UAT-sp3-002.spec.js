import { test, expect, chromium } from '@playwright/test';
import { validateHighlightDetailsPage } from './utils/utils';

let browser;
let context;
let page;

const baseURL = "https://cs05sec267.cpkkuhost.com";
// const baseURL = "http://127.0.0.1:8000";

// Launch the browser before all tests
test.beforeAll(async () => {
  // If you want to see the browser window, set headless: false.
  browser = await chromium.launch({ headless: false });
  context = await browser.newContext();
  page = await context.newPage();
});

// Close the browser after all tests have run
test.afterAll(async () => {
  await context.close();
  await browser.close();
});

test.describe.serial('View Highlight Module', () => {
  test('TC1: View All Highlights', async () => {
    await test.step('open home page', async () => {
      await page.goto(baseURL);
      await expect(page).toHaveTitle(/ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์/);
    });

    await test.step('click on highlight navbar', async () => {
      await page.click('text=Highlights');
      // Verify that we are on /allhighlights
      await expect(page).toHaveURL(`${baseURL}/allhighlights`);
      // Verify that the page has a title
      await expect(page.locator('h1')).toHaveText('Highlights');
    });
  });

  test('TC2: View Selected Highlight', async () => {
    await test.step('click on a highlight', async () => {
      // Go to the "allhighlights" page
      await page.goto(`${baseURL}/allhighlights`);

      // Click the first highlight card
      await page.locator('.highlight-item').first().click();

      // Expect the URL to match /highlightdetail/{id}
      await expect(page).toHaveURL(/highlightdetail\//);
    });
  });

  test('TC3: Validate Highlight Details Page Content', async () => {
    // Call the utility function to validate the details page
    await validateHighlightDetailsPage(page);
  });
});