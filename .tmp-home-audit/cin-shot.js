const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ channel: "chrome" });
  const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
  await page.goto("http://localhost:8081/?v=cin1", { waitUntil: "domcontentloaded", timeout: 60000 });
  await page.waitForSelector("[data-wvn-cin-story]", { timeout: 20000 });
  await page.locator("[data-wvn-cin-story]").scrollIntoViewIfNeeded();
  await page.waitForTimeout(700);
  await page.locator(".wvn-cin-story__sticky").screenshot({ path: "D:/weddingvows/.tmp-home-audit/cin-story.png" });
  await page.evaluate(() => {
    const el = document.querySelector("[data-wvn-cin-story]");
    const top = el.getBoundingClientRect().top + window.scrollY;
    const travel = el.offsetHeight - window.innerHeight;
    window.scrollTo(0, top + travel * 0.45);
  });
  await page.waitForTimeout(500);
  await page.locator(".wvn-cin-story__sticky").screenshot({ path: "D:/weddingvows/.tmp-home-audit/cin-story-mid.png" });
  await page.locator("[data-wvn-cin-vows]").scrollIntoViewIfNeeded();
  await page.waitForTimeout(500);
  await page.locator(".wvn-cin-vows__sticky").screenshot({ path: "D:/weddingvows/.tmp-home-audit/cin-vows.png" });
  await page.locator("[data-wvn-cin-cites]").scrollIntoViewIfNeeded();
  await page.waitForTimeout(400);
  await page.locator("[data-wvn-cin-cites]").screenshot({ path: "D:/weddingvows/.tmp-home-audit/cin-cites.png" });
  console.log("ok");
  await browser.close();
})();
