import { test, expect } from '@playwright/test';

export async function waitForPageLoad(page) {
    await page.waitForLoadState('load'); // Wait for the 'load' event
}