import { test, expect, chromium } from '@playwright/test';
import { validateHighlightDetailsPage } from './utils/utils';

let browser;
let context;
let page;

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
  test('TC1: View Highlights via Home Page', async () => {
    await test.step('open home page and verify highlights banner', async () => {
      // open home page and verify title
      await page.goto('https://cs05sec267.cpkkuhost.com/');
      await expect(page).toHaveTitle(/ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์/);

      // check if highlights banner is visible
      const highlightsBanner = page.locator('.hl-banner');
      await expect(highlightsBanner).toBeVisible();

      // ensure that there is at least one highlight item
      const carouselItems = highlightsBanner.locator('.carousel-item');
      const carouselItemCount = await carouselItems.count();
      expect(carouselItemCount).toBeGreaterThan(0);

      // verify that the first item is active
      await expect(carouselItems.first()).toHaveClass(/active/);

      // click next button and verify that the first item is no longer active
      const nextButton = highlightsBanner.locator('.carousel-control-next');
      await nextButton.click();

      // if more than one item, the first item should no longer be active
      if (carouselItemCount > 1) {
        await page.waitForTimeout(1000);
        await expect(carouselItems.first()).not.toHaveClass(/active/);
      }
    });
  });

  test('TC2: Validate highlight details page', async () => {
    await test.step('click highlight banner', async () => {
      // open home page
      await page.goto('https://cs05sec267.cpkkuhost.com/');

      // check if highlights banner is visible
      const highlightsBanner = page.locator('.hl-banner');
      await expect(highlightsBanner).toBeVisible();

      // click the first highlight link
      const firstHighlightLink = highlightsBanner.locator('a[id^="highlightLink-"]').first();
      await firstHighlightLink.click();

      // wait for the page to load
      await page.waitForLoadState('networkidle');
      await page.waitForTimeout(5000);
    });

    await test.step('validate highlight details page', async () => {
      // Call the utility function to validate the details page
      await validateHighlightDetailsPage(page);
    });
  });
});