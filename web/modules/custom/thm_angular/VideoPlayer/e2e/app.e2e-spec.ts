import { VideoPlayerPage } from './app.po';

describe('video-player App', () => {
  let page: VideoPlayerPage;

  beforeEach(() => {
    page = new VideoPlayerPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
