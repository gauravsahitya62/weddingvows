const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ channel: "chrome" });
  const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
  await page.goto("http://localhost:8081/?v=1832b", { waitUntil: "domcontentloaded", timeout: 60000 });
  await page.waitForSelector("#testimonials", { timeout: 20000 });
  await page.locator("#testimonials").scrollIntoViewIfNeeded();
  await page.waitForTimeout(1000);
  const info = await page.evaluate(() => {
    const imgs = [...document.querySelectorAll(".wvn-quotes-rail__frame img")].map(img => ({
      src: img.currentSrc || img.src,
      naturalW: img.naturalWidth,
      naturalH: img.naturalHeight,
      complete: img.complete
    }));
    return imgs;
  });
  console.log(JSON.stringify(info, null, 2));
  await page.locator("#testimonials").screenshot({ path: "D:/weddingvows/.tmp-home-audit/quotes-final.png" });
  await browser.close();
})();
