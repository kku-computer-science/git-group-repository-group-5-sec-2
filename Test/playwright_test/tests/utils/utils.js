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