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
  test('TC1: Select Highlight', async () => {
    await test.step('open all highlight page', async () => {
      await page.goto(`${baseURL}/allhighlights`);
      await expect(page.locator('h1')).toHaveText('Highlights');
    });

    await test.step('click on a highlight', async () => {
      // Click the first highlight card
      await page.locator('.highlight-item').first().click();
      await page.waitForTimeout(2000);
    });
  });

  test('TC2: See other related highlights', async () => {
    await test.step('click on a tag and verify content', async () => {
      // check if the page has a tag list
      const tagList = page.locator('#tagsInfo a[id^="tagLink-"]');
      const tagCount = await tagList.count();
      if (tagCount > 0) {
        const firstTag = await tagList.first();
        const tagText = await firstTag.textContent();
        await firstTag.click();
        await page.waitForTimeout(2000);
        await page.waitForLoadState('networkidle');

        // Verify that the URL navigates to a tag page (URL contains "tag")
        await expect(page).toHaveURL(/tag/);

        // verify that the page displays the tag text.
        await expect(page.locator('span.text-secondary')).toContainText(tagText);  

        // Verify that the tag page displays at least one highlight item
        const highlightItems = page.locator('.highlight-item');
        const itemCount = await highlightItems.count();
        expect(itemCount).toBeGreaterThan(0);
      }
    });
  });

  test('TC3: View Selected Highlight', async () => {
    await test.step('click on a related highlight', async () => {
      // Click the first related highlight card
      await page.locator('.highlight-item').first().click();
      await page.waitForTimeout(2000);
    });
  });

  test('TC4: Validate Highlight Details Page Content', async () => {
    // Call the utility function to validate the details page
    await validateHighlightDetailsPage(page);
  });
});