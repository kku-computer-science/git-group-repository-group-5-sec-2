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
  test('TC1: View all Highlights via All Highlights Page', async () => {
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

  test('TC2: filter highlight by tag', async () => {
    await test.step('click on menu filter', async () => {
      await page.click('text=Search By Tag');
      // verify that we are on /search-results
      await expect(page).toHaveURL(`${baseURL}/search-results`);
    });

    await test.step('select a tag', async () => {
      // type the tag name in the search box
      await page.fill('#tagSearch', 'cpkku');

      // wait briefly for the suggestions to appear
      await page.waitForTimeout(1000);

      // Click the first matching suggestion
      const suggestion = page.locator('.tag-suggestion').filter({ hasText: 'cpkku' }).first();
      await suggestion.click();

      // The page should now fetch and display highlights that match this tag
      await page.click('footer');
      await page.waitForTimeout(1000);
    });

    await test.step('verify filtered highlights', async () => {
      // Found x results
      const countText = await page.locator('p.text-muted:has-text("Found")').first().textContent();
      // Extract the numeric count with a regex
      const match = countText.match(/\d+/);
      expect(match).not.toBeNull();
      const reportedCount = match ? parseInt(match[0], 10) : 0;

      // Check the actual number of highlight items
      const highlightItems = page.locator('.col-12');
      const actualCount = await highlightItems.count();

      // Ensure the displayed count matches the actual count
      expect(actualCount).toBe(reportedCount);

      // Check that each highlight item is visible and has the correct content
      for (let i = 0; i < actualCount; i++) {
        const item = highlightItems.nth(i);

        // Verify an image is present
        await expect(item.locator('img')).toBeVisible();

        // Verify a title is present
        await expect(item.locator('h5.fw-bold.text-primary')).toBeVisible();

        // Verify a detail snippet is present
        await expect(item.locator('p.text-muted.mb-2')).toBeVisible();

        // Verify the creation date is present
        await expect(item.locator('div.text-muted')).toBeVisible();
      }
    });
  });

  test('TC3: View Selected Highlight', async () => {
    await test.step('click the first highlight result', async () => {
      // Locate the first highlight item in the filtered list
      const firstFilteredItem = page.locator('.col-12').first();
      await firstFilteredItem.click();
    });
  });

  test('TC4: Validate highlights details page content', async () => {
    // Call the utility function to validate the details page
    await validateHighlightDetailsPage(page);
  });
});