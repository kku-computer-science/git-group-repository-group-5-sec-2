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

// TC1: View Highlights via Home Page
test.describe('TC1: View Highlights via Home Page', () => {
  test('open home page and verify highlights banner', async () => {
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

// TC2: Validate Highlight Details Page, Tags, and Image Modal
test.describe('TC2: Validate highlight details page', () => {
  test('click highlight banner', async () => {
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
  });

  test('verify required content in highlight details page', async () => {
    // verify that the detail page content is visible
    await expect(page.locator('img.cover-image')).toBeVisible();  // cover image
    await expect(page.locator('h1.title')).toBeVisible();         // title
    await expect(page.locator('p#creationInfo')).toBeVisible();   // creation info
    await expect(page.locator('pre.detail')).toBeVisible();     // detail
  });

  test('verify image modal', async () => {
    // check if there is at least one image in the gallery
    const galleryImages = page.locator('.img-container .image');
    const galleryImageCount = await galleryImages.count();
    expect(galleryImageCount).toBeGreaterThan(0);

    // click the first image and verify that the modal is visible
    const firstGalleryImage = galleryImages.first();
    const modalTarget = await firstGalleryImage.getAttribute('data-bs-target');
    if (modalTarget) {
        // Click the image to trigger the modal
        await firstGalleryImage.click();

        // locate the modal and verify that it is visible
        const modal = page.locator(modalTarget);
        await expect(modal).toBeVisible({ timeout: 3000 });

        // verify that the modal displays the image
        const modalImage = modal.locator('img.img-fluid');
        await expect(modalImage).toBeVisible();

        // close the modal
        const closeButton = modal.locator('button[data-bs-dismiss="modal"]');
        await closeButton.click();

        // verify that the modal is no longer visible
        await expect(modal).not.toBeVisible({ timeout: 3000 });
    }
  });

  test('verify tag list', async () => {
    // check if there is at least one tag in the tag list
    const tagList = page.locator('#tagsInfo a[id^="tagLink-"]');
    // await expect(page.locator('p#tagsInfo')).toBeVisible();
    const tagCount = await tagList.count();
    expect(tagCount).toBeGreaterThan(0);

    // click the first tag and verify that the page navigates to the tag page
    const firstTag = tagList.first();
    const tagText = await firstTag.textContent();
    if (tagText) {
      await firstTag.click();
      await page.waitForLoadState('networkidle');
      // verify that url navigate to tag page
      await expect(page).toHaveURL(/tag/); 
      // verify that tag page title matches the clicked tag
      // await expect(page.locator('text-secondary')).toContainText(new RegExp(`tagText`));  // TODO: fix this
      // verify that the tag page displays info correctly
      const highlightItems = page.locator('.highlight-item');
      const count = await highlightItems.count();
      for (let i = 0; i < count; i++) {
        await expect(highlightItems.nth(i)).toBeVisible();
      }
    }
  });
});
