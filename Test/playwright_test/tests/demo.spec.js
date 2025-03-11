import { test, expect } from '@playwright/test';
import { waitForPageLoad, login } from './utils/utils';
// import { testData } from './test-data';
import path from 'path';

test.describe.serial("CREATE module",() => {
    const baseURL = "https://formstone.it/components/upload/demo/";

    test("upload test", async ({page}) => {
        await page.goto(baseURL);
        // await page.locator('#example-0').getByText('Drag and drop files or click').click();
        // const fileChooserPromise = page.waitForEvent('filechooser');
        // const fileChooser = await fileChooserPromise;
        // await fileChooser.setFiles(path.join(__dirname, testData.cover_image));

        await page.locator(`xpath=//*[@id="example-0"]/form/div[1]/input`).setInputFiles(path.join('../image' ,'2024-12-2-1733715590-1.png'));

        await page.waitForTimeout(5000);

    });

});