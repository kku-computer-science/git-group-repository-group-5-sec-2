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
}