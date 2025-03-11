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
    
        // Retrieve the modal target attribute
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