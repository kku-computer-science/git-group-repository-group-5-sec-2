import { test, expect } from '@playwright/test';


export async function waitForPageLoad(page) {
    await page.waitForLoadState('load'); // Wait for the 'load' event
}

// login function
export async function login(page, baseURL, username, password) {
    await page.goto(baseURL);
    const page1Promise = page.waitForEvent('popup');
    await page.getByRole('link', { name: 'Login' }).click();
    const page1 = await page1Promise;

    await page1.locator('#username').click();
    await page1.locator('#username').fill(username);
    
    await page1.getByRole('textbox', { name: 'Password' }).click();
    await page1.getByRole('textbox', { name: 'Password' }).fill(password);

    await page1.getByRole('button', { name: 'Log In' }).click();
    
    await waitForPageLoad(page1);
    await expect(page1).toHaveURL(`${baseURL}/dashboard`);

    return page1;
}

export async function addTag(field, tagName) {
    await field.fill(tagName);
    await field.press('Enter');
}

// validate highlight details page
export async function validateHighlightDetailsPage(page) {
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

    // Verify image modal functionality
    await page.locator('.img-container').first().scrollIntoViewIfNeeded();
    await page.waitForTimeout(3000);
    const galleryImages = page.locator('.img-container .image');
    const galleryImageCount = await galleryImages.count();

    if (galleryImageCount > 0) {
        for (let i = 0; i < galleryImageCount; i++) {
            const currentImage = galleryImages.nth(i);
            await currentImage.scrollIntoViewIfNeeded();

            const modalTarget = await currentImage.getAttribute('data-bs-target');
            if (modalTarget) {
                // Open modal
                await currentImage.click();
                const modal = page.locator(modalTarget);
                await expect(modal).toBeVisible({ timeout: 3000 });

                // Verify the modal displays an image
                const modalImage = modal.locator('img.img-fluid');
                await expect(modalImage).toBeVisible();

                // Close the modal
                const closeButton = modal.locator('button[data-bs-dismiss="modal"]');
                await closeButton.click();
                await expect(modal).not.toBeVisible({ timeout: 3000 });
            }
        }
    }

    // Verify tag results page content
    const tagList = page.locator('#tagsInfo a[id^="tagLink-"]');
    await expect(page.locator('p#tagsInfo')).toBeVisible();
    const tagCount = await tagList.count();
    
    if (tagCount > 0) {
        for (let i = 0; i < tagCount; i++) {
            const currentTag = tagList.nth(i);
            const tagText = await currentTag.textContent();
            if (tagText) {
                // Click the tag link
                await currentTag.click();
                await page.waitForLoadState('networkidle');

                // Verify URL navigates to a tag page
                await expect(page).toHaveURL(/tag/);

                // Verify the tag text is displayed on the page (e.g. in a span with class "text-secondary")
                await expect(page.locator('span.text-secondary')).toContainText(tagText);

                // Verify the tag page displays at least one highlight item
                const highlightItems = page.locator('.highlight-item');
                const itemCount = await highlightItems.count();
                expect(itemCount).toBeGreaterThan(0);

                // Go back to the highlight details page
                await page.goBack();
                await page.waitForLoadState('networkidle');
            }
        }
    }
}