import { test, expect, chromium } from '@playwright/test';

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

    await test.step('verify required content in highlight details page', async () => {
      // scroll to cover image
      await page.locator('img.cover-image').scrollIntoViewIfNeeded();
      await page.waitForTimeout(2000);
      await expect(page.locator('img.cover-image')).toBeVisible();

      // scroll to title
      await page.locator('h1.title').scrollIntoViewIfNeeded();
      await page.waitForTimeout(2000);
      await expect(page.locator('h1.title')).toBeVisible();

      // scroll to creation info
      await page.locator('p#creationInfo').scrollIntoViewIfNeeded();
      await page.waitForTimeout(2000);
      await expect(page.locator('p#creationInfo')).toBeVisible();
      // verify cration ifo format
      const creationText = await page.locator('p#creationInfo').textContent();
      const trimmedText = creationText.trim();
      // Define a regex to check for a datetime in the format "YYYY-MM-DD HH:MM"
      const dateTimeRegex = /\d{4}-\d{2}-\d{2} \d{2}:\d{2}/;
      // Check if the trimmed text matches the regex
      await expect(trimmedText).toMatch(dateTimeRegex);

      // scroll to detail
      await page.locator('pre.detail').scrollIntoViewIfNeeded();
      await page.waitForTimeout(2000);
      await expect(page.locator('pre.detail')).toBeVisible();
    });

    await test.step('verify image modal', async () => {
      // scroll to image gallery
      await page.locator('.img-container').scrollIntoViewIfNeeded
      await page.waitForTimeout(3000);
      // check if there is at least one image in the gallery
      const galleryImages = page.locator('.img-container .image');
      const galleryImageCount = await galleryImages.count();
      expect(galleryImageCount).toBeGreaterThan(0);

      // Loop through each gallery image
      for (let i = 0; i < galleryImageCount; i++) {
        const currentImage = galleryImages.nth(i);
        // Scroll the image into view
        await currentImage.scrollIntoViewIfNeeded();

        // Retrieve the modal target attribute (e.g., "#imageModal1")
        const modalTarget = await currentImage.getAttribute('data-bs-target');
        if (modalTarget) {
          // Click the image to open its modal
          await currentImage.click();

          // Locate the modal using the selector from data-bs-target
          const modal = page.locator(modalTarget);
          await expect(modal).toBeVisible({ timeout: 3000 });

          // Verify that the modal displays the image
          const modalImage = modal.locator('img.img-fluid');
          await expect(modalImage).toBeVisible();

          // Close the modal by clicking the close button
          const closeButton = modal.locator('button[data-bs-dismiss="modal"]');
          await closeButton.click();

          // Verify that the modal is no longer visible
          await expect(modal).not.toBeVisible({ timeout: 3000 });
        }
      }
    });

    await test.step('verify tag results page content', async () => {
      // check if there is at least one tag in the tag list
      const tagList = page.locator('#tagsInfo a[id^="tagLink-"]');
      await expect(page.locator('p#tagsInfo')).toBeVisible();
      const tagCount = await tagList.count();
      expect(tagCount).toBeGreaterThan(0);

      // Loop through each tag link
      for (let i = 0; i < tagCount; i++) {
        const currentTag = tagList.nth(i);
        const tagText = await currentTag.textContent();
        if (tagText) {
          // Click the current tag link
          await currentTag.click();
          await page.waitForLoadState('networkidle');

          // Verify that the URL navigates to a tag page (URL contains "tag")
          await expect(page).toHaveURL(/tag/);

          // verify that the page displays the tag text.
          await expect(page.locator('span.text-secondary')).toContainText(tagText);

          // Verify that the tag page displays at least one highlight item
          const highlightItems = page.locator('.highlight-item');
          const itemCount = await highlightItems.count();
          expect(itemCount).toBeGreaterThan(0);

          // Go back to the highlight details page to continue checking the next tag
          await page.goBack();
          await page.waitForLoadState('networkidle');
        }
      }
    });
  });
});