import { test, expect, chromium } from '@playwright/test';

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
      const tagList = page.locator('#tagsInfo a[id^="tagLink-"]');
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